<?php
declare(strict_types=1);

namespace AdminLTE\Model\Behavior;

use ArrayObject;
use Cake\Core\Configure;
use Cake\Event\EventInterface;
use Cake\ORM\Behavior;
use Cake\ORM\Table;

class DatepickerBehavior extends Behavior
{
    /**
     * @var array<string, mixed>
     */
    protected array $_defaultConfig = [
        'fields' => [],
        'date_separator' => '/',
    ];

    public function __construct(Table $table, array $config = [])
    {
        $config += $this->_defaultConfig;
        parent::__construct($table, $config);
    }

    /**
     * Normalizes locale-formatted date strings to ISO (Y-m-d) before they
     * reach the ORM marshaller.
     */
    public function beforeMarshal(EventInterface $event, ArrayObject $data, ArrayObject $options): void
    {
        if (empty($this->_config) || empty($this->_config['fields'])) {
            return;
        }

        $separator = $this->_config['date_separator'] ?: '/';
        $locale = Configure::read('App.defaultLocale');

        foreach ($this->_config['fields'] as $key) {
            if (!isset($data[$key])) {
                continue;
            }

            $parts = explode($separator, (string)$data[$key]);
            if (count($parts) !== 3) {
                continue;
            }

            if ($locale === 'pt_BR') {
                [$d, $m, $y] = $parts;
            } else {
                [$m, $d, $y] = $parts;
            }

            $data[$key] = $y . '-' . $m . '-' . $d;
        }
    }
}
