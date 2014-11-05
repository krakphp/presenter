<?php

namespace Krak\Presenter\Provider;

use Krak\Presenter\ViewPresenter,
    Pimple\ServiceProviderInterface,
    Pimple\Container,
    RuntimeException,
    Symfony\Component\Config\FileLocator;

class ViewPresenterServiceProvider implements ServiceProviderInterface
{
    public function register(Container $app)
    {
        $app['presenter.paths'] = null;
        $app['presenter.ext'] = '';
        $app['presenter.view_alias'] = 'view';

        $app['presenter'] = function(Container $app)
        {
            $this->initFileLocator($app);

            return new ViewPresenter(
                $app['presenter.file_locator'],
                $app['presenter.ext'],
                $app['presenter.view_alias']
            );
        };
    }

    private function initFileLocator(Container $app)
    {
        if (isset($app['presenter.file_locator'])) {
            return;
        }

        if (!$app['presenter.paths']) {
            throw new RuntimeException('presenter.paths has not been set');
        }

        $app['presenter.file_locator'] = function (Container $app)
        {
            return new FileLocator($app['presenter.paths']);
        };
    }
}
