<?php
use YPHP\Entity;
use YPHP\EntityFertility;
use YPHP\Storage\TranslationStorage;
use YPHP\Translation;
use YPHP\TranslationService;

TranslationService::getInstance()->getTranslations()->merge(
    (new TranslationStorage([
        new Translation(
            Entity::class,
            EntityFertility::class,
            function(Entity $entity,EntityFertility $entityFertility = null){
                $entityFertility = $entityFertility ? $entityFertility : new EntityFertility();
                $entityFertility->setId($entity->getId());
                return $entityFertility;
            }
        ),
    ]))->indexing()
);