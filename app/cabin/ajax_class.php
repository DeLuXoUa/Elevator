<?php
namespace cabin;

class ajax_class extends \cabin\cabin_class
{

    public function parsePost($post)
    {
        if ($post['method'] && method_exists($this, $post['method'])) {
            if ($post['method'] == 'get_info') {
                echo json_encode(['ok' => true, 'set_data' => $this->{$post['method']}($post)]);
            } else {
                try {
                    $this->{$post['method']}(empty($post['value']) ? null : $post['value']);
                } catch (\Exception $e) {
                    echo json_encode(['ok' => false, 'error' => $e->getMessage()]);
                }
            }
        }
    }

    private function get_info($post)
    {
        if (!$this->getParam('_in_floor'))
            $this->chooseDirection(true, true);
        return [
            'floor' => $this->getParam('_in_floor'),
            'direction' => $this->getParam('_direction'),
            'stopped' => $this->getParam('_stopped'),
            'calls_stack' => $this->getParam('_floors_stack')
        ];
    }

    private function to_floor($floor)
    {
        $this->touchPanel((int)$floor);
        $this->runGui(false);
    }

    private function start()
    {
        $this->runGui(false);
    }

}