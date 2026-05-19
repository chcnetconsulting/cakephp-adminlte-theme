<?php
declare(strict_types=1);

namespace AdminLTE\View;

use App\View\AppView;
use Cake\Core\App;
use Cake\Utility\Inflector;

class AdminLTEView extends AppView
{
    protected function _paths(?string $plugin = null, bool $cached = true): array
    {
        $prefixParam = $this->getRequest()->getParam('prefix');
        $prefix = $prefixParam ? Inflector::camelize($prefixParam) : false;
        $theme = $this->getTheme();

        $templatePaths = App::path(static::NAME_TEMPLATE);

        $pluginPaths = [];
        $themePaths = [];

        foreach ($templatePaths as $templateCurrent) {
            if (!empty($theme)) {
                if (!empty($plugin)) {
                    for ($i = 0, $count = count($templatePaths); $i < $count; $i++) {
                        if ($prefix) {
                            $pluginPaths[] = $templatePaths[$i] . 'plugin' . DIRECTORY_SEPARATOR . $theme . DIRECTORY_SEPARATOR . 'Plugin' . DIRECTORY_SEPARATOR . $plugin . DIRECTORY_SEPARATOR . $prefix . DIRECTORY_SEPARATOR;
                        }

                        $pluginPaths[] = $templatePaths[$i] . 'plugin' . DIRECTORY_SEPARATOR . $theme . DIRECTORY_SEPARATOR . 'Plugin' . DIRECTORY_SEPARATOR . $plugin . DIRECTORY_SEPARATOR;
                    }
                }

                if ($prefix) {
                    $themePaths[] = $templateCurrent . 'plugin' . DIRECTORY_SEPARATOR . $theme . DIRECTORY_SEPARATOR . $prefix . DIRECTORY_SEPARATOR;
                }

                $themePaths[] = $templateCurrent . 'plugin' . DIRECTORY_SEPARATOR . $theme . DIRECTORY_SEPARATOR;
            }
        }

        $paths = array_merge(
            $pluginPaths,
            $themePaths,
            parent::_paths($plugin, $cached)
        );

        return $this->_paths = $paths;
    }
}
