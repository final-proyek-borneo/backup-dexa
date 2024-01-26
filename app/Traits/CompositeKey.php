<?php
namespace App\Traits;

use Illuminate\Database\Eloquent\Builder;

trait CompositeKey
{
    public function getIncrementing(){
        return false;
    }

    protected function setKeysForSaveQuery($query){
        $keys = $this->getKeyName();
        if(!is_array($keys)){
            return parent::setKeysForSaveQuery($query);
        }
        foreach($keys as $keyName){
            $query->where($keyName, '=', $this->getKeyForSaveQuery($keyName));
        }
        return $query;
    }
}
?>
