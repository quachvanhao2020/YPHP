<?php
namespace YPHP\Factory;

use YPHP\Hydrator\ClassMethodsHydrator;
use VietThuongWb\Model\Storage\ProductStorage;
use VietThuongWb\Model\Product;
use YPHP\FilterInputInterface;
use YPHP\SortingInputInterface;
use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx;
use YPHP\StorageHydratorTrait;
use Laminas\Hydrator\Strategy\DateTimeArrayFormatterStrategy;
use Laminas\Hydrator\Strategy\EnumStrategy;
use Laminas\Hydrator\Strategy\NewClassStrategy;
use Laminas\Hydrator\Strategy\StorageStrategy;
use PhpOffice\PhpSpreadsheet\Worksheet\Worksheet;
use YPHP\Entity;
use YPHP\EntityFertility;
use YPHP\EntityInterface;
use Laminas\Hydrator\HydratorInterface;

trait ExcelEntityFactoryTrait{
    use StorageHydratorTrait;

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

    public function __construct(string $fileName = null,bool $autoSave = true)
    {
        $this->storage = $this->getStorage();
        $this->hydrator = new ClassMethodsHydrator(false);
        $this->fileName = $fileName;
        try {
            $spreadsheet = \PhpOffice\PhpSpreadsheet\IOFactory::load($fileName);
            $sheet = $spreadsheet->getActiveSheet();
            $array = \array_column_to_array($sheet->toArray());
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
        $this->autoSave = $autoSave;
        $this->storage->indexing();
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

    /**
     * Get the value of strategys
     *
     * @return  StrategyInterface[]
     */ 
    public static function getStrategys(HydratorInterface $hydrator)
    {
        $minimum_new_class = new NewClassStrategy($hydrator);
        $new_class = new NewClassStrategy($hydrator,false);
        $storage_strategy = new StorageStrategy();
        return [
            Product::STATUS => [
                "strategy" => new EnumStrategy(),
                "recursive" => true,
                "children" => [],
            ],
            Product::ATTRIBUTES => [
                "strategy" => $storage_strategy,
                "recursive" => true,
                "children" => [],
            ],
            Product::VARIANTS => [
                "strategy" => $storage_strategy,
                "recursive" => true,
                "children" => [],
            ],
            Product::DATECREATED => [
                "strategy" => new DateTimeArrayFormatterStrategy(),
                "recursive" => true,
                "children" => [],
            ],
            Product::CATEGORY => [
                "strategy" => $minimum_new_class,
                "recursive" => true,
                "children" => [],
            ],
            Product::LOGO => [
                "strategy" => $new_class,
                "recursive" => true,
                "children" => [],
            ],
            Product::CHILDREN => [
                "strategy" => $storage_strategy,
                "recursive" => true,
                "children" => [],
            ],
            Product::PARENT => [
                "strategy" => $minimum_new_class,
                "recursive" => true,
                "children" => [],
            ],
        ];
    }

    public function __destruct()
    {
        if($this->autoSave) $this->save();
    }

    protected function save(){
        $storage = $this->storage;
        $storage->prepend($this->getNewEntity());
        $current = 1;
        foreach ($storage as $key => $value) {
            $this->write($value,$current);
            $current ++;
        }
        $writer = new Xlsx($this->spreadsheet);
        $writer->save($this->fileName);
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
     * @param  ProductStorage  $storage
     *
     * @return  self
     */ 
    public function setStorage(ProductStorage $storage = null)
    {
        $storage->indexing();
        $this->storage = $storage;

        return $this;
    }
}