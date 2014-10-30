Krak Presenter
==============

Simple yet powerful implementation of the presenter pattern.

## Installation

install via composer.

```json
{
    "repositories": [
        {
            "type": "vcs",
            "url": "http://gitlab.bighead.net/bighead/krak-presenter.git"
        }
    ],
    "require": {
        "krak/presenter": "~2.0",
        "doctrine/cache": "~1.0" // only if you use the CachePresenter
    }
}
```

## Usage

### Simple usage

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

### Caching

... more documentation coming soon

### TreeViews

... more documentation coming soon

### Anonymous Views

... more documentation coming soon
