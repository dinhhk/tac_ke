<?php 

namespace AdminBundle\Twig;

class GenerateIdExtension extends \Twig_Extension
{
    public function getFilters()
    {
        return array(
            new \Twig_SimpleFilter('generateId', array($this, 'generateId')),
        );
    }

    public function generateId($id, $key = 'I', $character = '0', $repeat = 4)
    {
        return $key . str_pad($id, $repeat - strlen($id), $character, STR_PAD_LEFT);
    }

    public function getName()
    {
        return 'generate_id_extension';
    }
}