<?php
class Sqlsvr_model  extends grocery_CRUD_Model {

function get_primary_key($table_name = null)
{
if($table_name == null)
{
   return 'Id'; // <-------- change this line here, write your table's primary key there
}
else
{
  $fields = $this->get_field_types($table_name);
  foreach($fields as $field)
  {
     if($field->primary_key == 1)
   {
	return $field->name;
   }
  }

 return 'Id';
}
return 'Id'; 
}


}