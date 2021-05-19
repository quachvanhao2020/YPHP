<?php
namespace YPHP\Factory;

use YPHP\Hydrator\ClassMethodsHydrator;
use YPHP\FilterInputInterface;
use YPHP\SortingInputInterface;
use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx;
use YPHP\StorageHydratorTrait;
use PhpOffice\PhpSpreadsheet\Worksheet\Worksheet;
use YPHP\Entity;
use YPHP\EntityFertility;
use YPHP\EntityInterface;
use Laminas\Hydrator\HydratorInterface;
use YPHP\EventManagerInject;
use YPHP\Storage\EntityStorageInterface;
use YPHP\Storage\EntityStorage;

trait ExcelEntityFactoryTrait{
    use StorageHydratorTrait;
    use EventManagerInject;
    /**
     * @var ProductStorage
     */
    protected $storage;

    /**
     * @var Spreadsheet
     */
    protected $spreadsheet;

    /**
     * @var string
     */
    protected $fileName;

    /**
     * @var bool
     */
    protected $autoSave = true;

        /**
     * @var array
     */
    protected $mexel = [];

    public function __construct(string $fileName = null,bool $autoSave = true,array $mexel = [])
    {
        $this->storage = $this->getStorage();
        $this->hydrator = new ClassMethodsHydrator(false);
        $this->fileName = $fileName;
        $this->autoSave = $autoSave;
        $this->mexel = $mexel;
        try {
            $spreadsheet = \PhpOffice\PhpSpreadsheet\IOFactory::load($fileName);
            $sheet = $spreadsheet->getActiveSheet();
            $array = \array_column_to_array($sheet->toArray());
            $this->mexelMes($array);
            $this->_convertArraySheet($array);
            foreach ($array as &$value) {
                $value = \array_index_value($value,"_");
                $value = $this->hydrate($value,$this->getNewEntity());
            }
            $this->storage->setStorage($array);
        } catch (\Exception $ex) {
            //throw $ex;
            $spreadsheet = new Spreadsheet();
        }
        $this->spreadsheet = $spreadsheet;
        $this->storage->indexing();
    }

    private function mexelMes(array &$data){
        foreach ($data as $key => &$value) {
            $this->mexelMe($value);
        }
    }

    private function mexelMe(array &$data){
        foreach ($data as $key => &$value) {
            foreach ($this->mexel as $k => $v) {
                if(@$v['name'] == $key){
                    $data[$k] = $value;
                    unset($data[$key]);
                }
                if(@$v['link']){
                    $data[$k] = $v['value'];
                }
            }
        }
        return $data;
    }

    protected abstract function _convertArraySheet(array &$array); 

    protected function getNewEntity(){
        $class = $this->getClassEntity();
        return new $class();
    }

    protected function write(EntityInterface $entity,int $index = 1,Worksheet $sheet = null){
        $sheet = $sheet ? $sheet : $this->spreadsheet->getActiveSheet();
        $entity = $this->extract($entity);
        $entity = \array_reverse($entity);
        unset($entity[Entity::__CLASS]);
        unset($entity[EntityFertility::CHILDREN]);
        unset($entity["iterator"]);
        unset($entity["container"]);
        $entity = \index_value_array($entity,"_");
        $entity = $this->mergeMexel($entity);
        $i = "A";
        foreach ($entity as $key => $value) {
            $coll = "{$i}{$index}";
            if($index == 1){
                $sheet->setCellValue($coll,$key);
            }else{
                $sheet->setCellValue($coll,$value);
            }
            $i ++;
        }
    }

    public function mergeMexel($array){
        $result = [];
        if(empty($this->mexel)) return $array;
        foreach ($this->mexel as $key => $value) {
            if($name = @$value['name']){
                $result[$name] = @$array[$key];
            }
        }
        return $result;
    }

    /**
     * Get the value of strategys
     *
     * @return  StrategyInterface[]
     */ 
    public static function getStrategys(HydratorInterface $hydrator)
    {
        return [
        ];
    }

    public function __destruct()
    {
        if($this->autoSave) $this->save();
    }

    public function save(){
        $storage = $this->storage;
        $storage->prepend($this->getNewEntity());
        $current = 1;
        foreach ($storage as $key => $value) {
            $this->write($value,$current);
            $current ++;
        }
        $writer = new Xlsx($this->spreadsheet);
        $writer->save($this->fileName);
        $this->trigger('save');
    }

    /**
     * Finds an entry of the container by its identifier and returns it.
     *
     * @param string $id Identifier of the entry to look for.
     *
     * @return Product
     */
    public function get($id){
        return $this->storage[$id];
    }
    /**
     * @param int $first
     * @param string $after
     * @param int $last
     * @param string $before
     * @param ProductFilter $filter
     * @param SortingInputInterface $sort
     * @return mixed
     */
    public function list(int $first = 0,string $after = "",int $last = -1,string $before = "",FilterInputInterface $filter = null,SortingInputInterface $sort = null){
        return $this->storage;
    }
    /**
     * @param string $id Identifier of the entry to look for.
     * @param Product $entity
     * @return bool
     */
    public function update($id,$entity){
        if(is_a($entity,$this->getClassEntity())) $this->storage[$id] = $entity;
    }
        /**
     * @param string $id Identifier of the entry to look for.
     * 
     * @return bool
     */
    public function delete($id){
        unset($this->storage[$id]);
    }

    /**
     * @param string $id Identifier of the entry to look for.
     * 
     * @return bool
     */
    public function has($id){
        return isset($this->storage[$id]);
    }

    /**
     * Get the value of storage
     *
     * @return EntityStorage
     */ 
    public abstract function getStorage();

        /**
     * Get the value of storage
     *
     * @return Entity
     */ 
    public abstract function getClassEntity();

    /**
     * Set the value of storage
     *
     * @param  EntityStorage  $storage
     *
     * @return  self
     */ 
    public function setStorage(EntityStorage $storage = null)
    {
        $storage->indexing();
        $this->storage = $storage;
        return $this;
    }
}