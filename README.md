Krak Presenter
==============

Simple yet powerful implementation of the presenter pattern.

## Installation

install via composer.

```javascript
{
    "repositories": [
        {
            "type": "vcs",
            "url": "http://gitlab.bighead.net/bighead/krak-presenter.git"
        }
    ],
    "require": {
        "krak/presenter": "~2.0",

        /* only if you use the CachePresenter */
        "doctrine/cache": "~1.0",

        /* include if you use the EventListener\ViewListener */
        "symfony/event-dispatcher": "~2.0",
        "symfony/http-kernel": "~2.0",
        "symfony/http-foundation": "~2.0",

        /* include if you use the Provider\ViewPresenterServiceProvder */
        "pimple/pimple": "~3.0"
    }
}
```

## Usage

Krak Presenter library comes bundled with 2 different presenters: View and Mock.

The View presenter will take a View model and return the appropriate content from the view file associated with the View model.

The Mock presenter is primarily used for testing, but it's just a simple wrapper around the [SplObjectStorage](http://php.net/manual/en/class.splobjectstorage.php).

### ViewPresenter

```php
<?php

use Krak\Presenter\ViewPresenter;
use Krak\Presenter\View\View;
use Krak\Presenter\View\ViewTrait;
use Symfony\Component\Config\FileLocator;

class MyView implements View
{
    use ViewTrait;

    private $view_file = 'my-view';

    // or just define the getViewFile function

    public function getViewFile()
    {
        return 'my-view';
    }

    public function getHeader()
    {
        return '<h1>Header</h1>';
    }
}

$presenter = new ViewPresenter(FileLocator(__DIR__ . '/views'), 'php', 'v');
echo $presenter->present(new MyView());
```

```php
// __DIR__ . /views/my-view.php
<html>
    <?=$v->getData()?>
</html>
```

the last echo statement would ouptut:

    <html>
        <h1>Header</h1>
    </html>

The ViewPresenter constructor takes a [FileLocator](http://symfony.com/doc/current/components/config/resources.html), an extension (defaults to an empty string), and an alias for the view model (defaults to 'view').

#### Extension

```php
$presenter->setExtension('php');
echo $presenter->getExtension();
// outputs: php
```

If there is an extension set, then it will append `.{ext}` to the end of each view file name.

#### Alias

```php
$presenter->setViewAlias('v_alias');
echo $presenter->getViewAlias();
// outputs: v_alias

// then in some-view file
<html>
    <?=$v_alias->getData()?>
</html>
```

### MockPresenter

```php
use Krak\Presenter\MockPresenter;

$presenter = new MockPresenter();
$view = new stdClass();
$presenter->mock($view, 'some-data');

echo $presenter->present($view);
```

the output will be

    some-data

## Decorators

The presenter system is designed around the `Presenter` interface which makes the use of decorators very easily.

```php
<?php

interface Presenter
{
    /**
     * @param mixed $data
     * @return string
     */
    public function present($data);

    /**
     * @param mixed $data
     * @return bool
     */
    public function canPresent($data);
}
```

This library comes with two decorators: Cache and Tree.

### Caching

The caching presenter is just a decorator that will try to get the presenter data out of
cache before actually going through the process of rendering the view.

```php
use Krak\Presenter\CachePresenter;
use Krak\Presenter\View\CacheableView;
use Doctrine\Common\Cache\ArrayCache;

class MyView implements CacheableView
{
    public function getCacheTuple()
    {
        return array('my-view-cache-key', 3600);
    }
}

/* $presenter is another instanceof Presenter defined beforehand */
$cache = new ArrayCache();
$cache_presenter = new CachePresenter($presenter, $cache);

$data = $cache_presetner->present(new MyView());

var_dump($data === $cache->fetch('my-view-cache-key');
```

the output will be true because the cache presenter added the data to the cache, and the next call to present on the same view model would just return the data from cache instead of delegating the presentation to it's internal presenter.

    bool(true)

Now, the CachePresenter will only cache views models that implement the `CacheableView` interface.

### TreeViews

The tree presenter is another decorator that allows a hierarchy/tree of views to be presented. A tree presenter will only traverse a tree of views if they implement the `TreeView` interface. One important note about the tree view is how it handles the presenting of multiple items at once.

The call `$tree_presenter->presenter($view)` will return the output of the `$view` object which is the root of the tree. It will then traverse the tree down and use it's internal presenter to get all of the data for each child view. It then injects the content presented back into child views to be used by any of the parents. Look at the following example.

```php
use Krak\Presenter\TreePresenter;
use Krak\Presenter\View\View;
use Krak\Presenter\View\TreeView;
use Krak\Presenter\View\TreeViewTrait;
use Krak\Presenter\ViewPresenter;

class TreeViewChild implements View, TreeView
{
    use ViewTrait;
    use TreeViewTrait;

    private $view_file = 'child-view.php';

    public function getData()
    {
        return 'some-data';
    }
}

class TreeViewParent implements View, TreeView
{
    use TreeViewTrait;

    private $child1;
    private $view_file = 'parent-view.php';

    public function __construct()
    {
        $this->child1 = new TreeViewChild();
    }

    public function getChildren()
    {
        return array($this->child1);
    }

    public function getChild1()
    {
        return $this->child1;
    }
}

$view_presenter = new ViewPresenter($locator);
$tree_presenter = new TreePresenter($view_presenter);

echo $tree_presenter->present(new TreeViewParent());
```

```php
// child-view.php
<span><?=$view->getData()?></span>
```

```php
// parent-view.php
<div>
    <?=$view->getChild1()->getContent()?>
</div>
```

the last echo statement would display

    <div>
        <span>some-data</span>
    </div>

## View Models

The view models are the actual object responsible for rendering the views. There are four types of views with the Krak Presenter library: Views, TreeViews, CacheableViews, and AnonymousViews.

### View

```php
interface View
{
    /**
     * @return string
     */
    public function getViewFile();
}
```

Very simple interface for retrieving the view file to be loaded. This interface is used by the ViewPresenter. You can use the `ViewTrait` to define those methods for you.

### TreeView

```php
interface TreeView
{
    /**
     * @return TreeView[]
     */
    public function getChildren();

    /**
     * Set the rendered content for this view
     * @var string
     */
    public function setContent($content);

    /**
     * get the rendered content for this view
     * @return string
     */
    public function getContent();
}
```

This interface is designed to be used with TreePresenter, and as you can see it allows traversal of a tree of TreeView models and allows each view to hold store their content. You can use the `TreeViewTrait` to define those methods for you.

### CacheableView

```php
interface CacheableView
{
    /**
     * Returns a tuple of the cache key and ttl
     * @return array
     */
    public function getCacheTuple();
}
```

This interface is designed to be used with the CachePresenter. A cache tuple looks like the following:

```php
array('key', 3600);
```

where the tuple has a key of 'key' and a ttl of 3600.

### Anonymous Views

Sometimes you don't need to build an entire class to just render a file with some data, for that, we have the Anonymous View models.

An Anonymous View implements the `View` interface. You can create anonymous view like so:

```php
use Krak\Presenter\View\AnonymousView;

$v = new AnonymousView('some-view-file', array('key'=>'val'));
// or
$v = AnonymousView::create('some-view-file'); // data is defaulted to an empty array
```

then in `some-view-file`

```php
<div>
    <?=$view->key?>
</div>
```

this view will render to:

    <div>
        val
    </div>

## Buffer

The buffer is a simple utility that comes in handy when working with TreeViews. A buffer essentially just holds string content, but you can share the same buffer with multiple views, and they will append to the same buffer.

For example, let's say you wanted to let each view define some javascript. And the javascript defined by each view should then be output at the bottom of the page. You could that easily with a buffer.

First, we'll assume that each view has the same instance of a buffer as a public variable with the name, `js_buf`.

```php
// root view file
<html>
    <body>
        <?=$view->getInnerView()->getContent()?>
    </body>
    <?=$view->js_buf->getContents()?>
</html>
```

```php
// inner view file
<?php $view->js_buf->start()?>
<script type="text/javascript">
    // some javascript
</script>
<?php $view->js_buf->end()?>
<div>
    <!-- content -->
</div>
```

## View Listener

If you use a project that is based off of the [Symfony HttpKernel](http://symfony.com/doc/current/components/http_kernel/introduction.html), you can register the view listener so that your controllers can return views and have them converted to responses.

```php
<?php

use Krak\Presenter\EventListener\ViewListener,
    Krak\Presenter\ViewPresenter;

$view_presenter = ...
$listener = new ViewListener($view_presenter);

/* dispatcher instanceof Symfony\Component\EventDispatcher\EventDispatcher */
$dispatcher->addSubscriber($listener);
```

Then in your controllers, you can just return a view model like so, and it will be converted to a response

```php
    public function showAction()
    {
        // ...

        /* instanceof Krak\Presenter\View\View */
        return new ViewModel();
    }
```
