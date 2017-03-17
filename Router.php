<?php

class Router
{

    private $get_controller_name = 'm_controller';
    private $get_action_name = 'm_action';
    private $routes;

	/*
	* ������������� ��������� ����������� � ��������.
	* @var $controller_value string - �������� �����������
	* @var $action_value string - �������� ��������
	* return 
	*/
    public function SetControllerAndActionURL($controller_value, $action_value)
    {
        $result = GetHostURL();

        $result = SetURL($result, $this->get_controller_name, $controller_value);
        $result = SetURL($result, $this->get_action_name, $action_value);

        return $result;
    }

	/*
	* �������� �������� ����������� �� GET ���������.
	* @var $defvalue string - �������� ���������� ('main' ��-���������)
	* return string
	*/
    private function GetControllerValue($defvalue = 'main')
    {
        return (isset($_GET[$this->get_controller_name])) ? $_GET[$this->get_controller_name] : $defvalue;
    }

	/*
	* �������� �������� �������� �� GET ���������.
	* @var $defvalue string - �������� �������� ('index' ��-���������)
	* return string
	*/
    private function GetActionValue($defvalue = 'index')
    {
        return (isset($_GET[$this->get_action_name])) ? $_GET[$this->get_action_name] : $defvalue;
    }

	/*
	* ��������� ��������, ���������� �����������.
	*/
    public function run()
    {
        global $SYSTEM_CHARSET;
		global $FILE_KINDINFO_ROOT_NAME;
		global $RQ_KINDINFO_INDEX_NAME;
        $controller = wordtoupper($this->GetControllerValue());
		
		$dir_name = GetGETIndex($RQ_KINDINFO_INDEX_NAME);
		
        $controller .= 'Controller';
		
		$filename = $FILE_KINDINFO_ROOT_NAME.$dir_name.'/controllers/'.$controller.'.php';
		
		if (file_exists($filename))
		{
			include_once $filename;
			$controller_obj = new $controller;
			$action =  strtolower($this->GetActionValue());

			if (is_callable([$controller_obj, $action]))
			{
				$controller_obj->$action();
			}
			else
			{
				echo '����� � ������������ �����������.<br>';
				echo '�� ������� ��������� ��������: ' . $action;
			}
		}
		else
		{
			echo '�� ������� ���������� ������ � ID: '.$dir_name;
			echo '<br>';
			echo '���� �� ������.';
		}
    }
}
