Krak Presenter
==============

Simple yet powerful implementation of the presenter pattern.

## Design

A Krak Presenter is a class that implements the Presenter interface. Currently, the only presenter base class bundled with the library is the ViewPresenter.

However, the Krak Presenter can easily be implemented so that you can present from the database, view files, sftp server, or anywhere else that makes sense. 

## Usage

Create your Presenter Model.

````php
<?php

namespace View\Home;

use Krak\Presenter;

/**
 * View Model
 */
class Index extends Presenter\ViewPresenter
{
    public $header;
    public $info;
    public $data;
    
    public function __construct()
    {
        $this->setFile($this->getViewFile());
    }
    
    public function setHeader($header)
    {
        $this->header = $header;
        return $this;
    }
    public function setInfo($info)
    {
        $this->info = $info;
        return $this;
    }
    public function setData($data)
    {
        $this->data = $data;
        return $this;
    }
    
    public function genDataRows()
    {
        foreach ($this->data as $row)
        {
            yield [
                'header'    => 'Id: ' . $row['id'],
                'content'   => htmlspecialchars($row['content']),
            ];
        }
    }
    
    public function escape($data)
    {
        return htmlspecialchars($data);
    }
    
    public function getViewFile()
    {
        if ($global_var_is_set) {
            return 'view-file-1';
        }
        else if ($is_desktop) {
            return 'view-file-2';
        }
        else if ($is_mobile) {
            return 'view-file-3';
        }
        
        throw new \Exception('View file could not be specified');
    }   
}
````

Above is a typical example of what a presenter would look like you in your application. Some presenter base classes need config to be set before you can start presenting.

````php
<?php

/* set the config */
Krak\Presenter\ViewPresenter::setConfig([
    'view_path' => 'app/views',
    'file_ext'  => 'php'
]);

````

After you set the global config, you can present your content like so.

````php
<?php

$v = new View\Home\Index();
$v->setTitle('Home')
    ->setInfo('I like using presenters')
    ->setData(get_data_from_some_where())
    ->build();
    
echo $v;
````

## ViewPresenter

The ViewPresenter allows the building of view files on the local filesystem.  Before you can use a ViewPresenter, you need to set the global config via `ViewPresenter::setConfig`.

Here are the following config options:

````php
<?php

use Krak\Presenter;

Presenter\ViewPresenter::setConfig(array(
    'view_path' => 'some-path/without/trailing/slash',
    'file_ext'  => 'php', // e.g. php, html.php, html.twig
));

/* start using the view presenters */
````

Using the Home\Index Presenter created above, here's what a view file could look like.

````php
<?php // view file ?>
<div id="content">
    <h1><?=$this->header?></h1>
    
    <?php // escape() is inherited from View\Common ?>
    <p><?=$this->escape($this->info)?></p>
    
    <div class="list">
        <?php foreach($this->genDataRows() as $row): ?>
        <div>
            <h2><?=$row['header']?></h2>
            <p><?=$row['content']?></p>
        </div>
        <?php endforeach; ?>
    </div>
</div>
````
