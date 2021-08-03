<?php
declare(strict_types = 1);

abstract class AbstractRowDisplay
{
    protected $allRows = [];

    public function addRow(array $newRow): void
    {
        $this->allRows[] = $newRow;
    }

    abstract protected function getStart() : string;
    abstract protected function getEnd() : string;
    abstract protected function getRowStart() : string;
    abstract protected function getRowEnd() : string;
    abstract protected function getElementStart() : string;
    abstract protected function getElementEnd() : string;

    public function get() : string
    {
        $result = $this->getStart();
        foreach ($this->allRows as $row)
        {
            $result .= $this->getRowStart(); 
            foreach ($row as $element)
            {
                $result .= $this->getElementStart() . $element . $this->getElementEnd();
            }
            $result .= $this->getRowEnd();
        }
        $result .= $this->getEnd();
        return $result;
    }

}

class TableDisplay extends AbstractRowDisplay
{ 
    protected function getStart () : string
    {
        return '<table>';
    }
    
    protected function getEnd() : string
    {
        return '</table>';
    }
    
    protected function getRowStart() : string
    {
        return '<tr>';
    }
    
    protected function getRowEnd () : string
    {
          return '</tr>';
    }
    
    protected function getElementStart () : string
    {
        return '<td>';
    }
    
    protected function getElementEnd () : string
    {
        return '</td>';
    }
}

class PostDisplay extends AbstractRowDisplay
{
    protected function getStart () : string
    {
        return '<table class = "individualPosts">';
    }
    
    protected function getEnd() : string
    {
        return '</table>';
    }
    
    protected function getRowStart() : string
    {
        return '<tr>';
    }
    
    protected function getRowEnd () : string
    {
          return '</tr>';
    }
    
    protected function getElementStart () : string
    {
        return '<td>';
    }
    
    protected function getElementEnd () : string
    {
        return '</td>';
    }
}

class AnnounceDisplay extends PostDisplay
{
    protected function getStart () : string
    {
        return '<table class = "individualPosts">';
    }
    
    protected function getEnd() : string
    {
        return '</table>';
    }
    
    protected function getRowStart() : string
    {
        return '<tr>';
    }
    
    protected function getRowEnd () : string
    {
          return '</tr>';
    }
    
    protected function getElementStart () : string
    {
        return '<td><b>';
    }
    
    protected function getElementEnd () : string
    {
        return '</b></td>';
    }
}

class ButtonDisplay
{
    protected function getStart() : string
    {
        return "<button type = 'submit' id = 'postButton'";
    }

    protected function getName(string $nameValue) : string
    {
        return "name = '$nameValue'";
    }

    protected function getValue(string $value) : string 
    {
        return "value = '$value'>";
    }

    protected function getButtonName(string $name) : string
    {
        return "$name";
    }

    protected function getEnd() : string
    {
        return "</button>";
    }

    public function get(string $nameValue, string $value, string $name) : string 
    {
        $result = $this->getStart();
        $result .= $this->getName($nameValue);
        $result .= $this->getValue($value);
        $result .= $this->getButtonName($name);
        $result .= $this->getEnd();
        return $result;
    }
}


