<?php

namespace App\View\Components;

use Closure;
use Illuminate\Contracts\View\View;
use Illuminate\View\Component;

use Symfony\Component\Console\Helper\Table;
use Symfony\Component\Console\Output\OutputInterface;
use Illuminate\Contracts\Support\Arrayable;

class DrawTable extends Component
{
    /**
     * Create a new component instance.
     */

    public $headers = [];
    public $rows = [];
    public $tableStyle = null;
    public $columnStyles = null;

    public function __construct($headers,$rows,$tableStyle = 'default', array $columnStyles = [])
    {
        $this->headers = $headers;
        $this->rows = $rows;
        $this->tableStyle = $tableStyle;
        $this->columnStyles = $columnStyles;
    }

    /**
     * Get the view / contents that represent the component.
     */
    public function render(): View|Closure|string
    {

        $_tbl = $this->rows;
        array_unshift($_tbl,$this->headers);

        //print_r($_tbl);die();

        $_rowlens = [];
        
        foreach ($_tbl as $row) {
            foreach ($row as $index => $value) {
                $_rowlens[$index] = !isset($_rowlens[$index]) ? strlen($value) : (strlen($value) > $_rowlens[$index] ? strlen($value) : $_rowlens[$index]);
            }
        }

        $output = "";
        $_line = '';

        foreach($_rowlens as $total) {
            $_line .= '+' . str_repeat('-',$total + 2) ;
        } 
        $_line .= "+\n";

        foreach ($_tbl as $key => $row) {

            $output .= (!$key || $key === 1) ? $_line : '';

            foreach ($row as $index => $value) {


                $rLen = ($_rowlens[$index] - strlen($value)) +1;
                $output .= '| ' . $value . str_repeat(" ",$rLen);
            }

            $output .= "|\n";
        }

        $output .= $_line;

        return '<pre><code>' . $output . '</code></pre>';

    }
}
