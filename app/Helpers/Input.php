<?php

function checkOld($index, $object, $type = null)
{
	if(old($index) != '')
	{
		return old($index);
	}

	if(isset($object->$index))
	{
		return $object->$index;
	}

	if($type == 'int')
	{
		return 0;
	}

	return '';
}

function checkOldValue($index, $value, $type = null)
{
	if(old($index) != '')
	{
		return old($index);
	}

	if(isset($value) && !is_array($value))
	{
		return $value;
	}

	if($type == 'int')
	{
		return 0;
	}

	return '';
}