<?php
declare(strict_types=1);

namespace AdminLTE\Test\TestCase;

use Cake\Core\Configure;
use Cake\TestSuite\TestCase;

class ConfiguresTest extends TestCase
{
    public function testDefaultConfigures(): void
    {
        $expected = [
            'title' => 'AdminLTE',
            'logo' => [
                'mini' => '<b>A</b>LT',
                'large' => '<b>Admin</b>LTE',
            ],
            'login' => [
                'show_remember' => true,
                'show_register' => true,
                'show_social' => true,
            ],
            'folder' => ROOT,
            'skin' => 'blue',
        ];

        include dirname(__DIR__, 2) . '/config/bootstrap.php';
        $this->assertEquals($expected, Configure::read('Theme'));
    }

    public function testNotOverridingUserConfigures(): void
    {
        $expected = [
            'title' => 'my site name',
            'logo' => [
                'mini' => 'ALT',
                'large' => 'AdminLTE',
            ],
            'login' => [
                'show_remember' => false,
                'show_register' => false,
                'show_social' => false,
            ],
            'folder' => ROOT . DIRECTORY_SEPARATOR . 'sub',
            'skin' => 'red',
        ];

        Configure::write('Theme', $expected);
        include dirname(__DIR__, 2) . '/config/bootstrap.php';
        $this->assertEquals($expected, Configure::read('Theme'));
    }
}
