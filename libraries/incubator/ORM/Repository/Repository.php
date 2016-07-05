<?php
/**
 * Part of the Joomla Framework ORM Package
 *
 * @copyright  Copyright (C) 2015 - 2016 Open Source Matters, Inc. All rights reserved.
 * @license    GNU General Public License version 2 or later; see LICENSE
 */

namespace Joomla\ORM\Repository;

use Joomla\ORM\DataMapper\DataMapperInterface;
use Joomla\ORM\Entity\EntityBuilder;
use Joomla\ORM\Exception\EntityNotFoundException;
use Joomla\ORM\Exception\OrmException;
use Joomla\ORM\Finder\CollectionFinderInterface;
use Joomla\ORM\Finder\EntityFinderInterface;
use Joomla\ORM\Finder\Operator;

/**
 * Class Repository
 *
 * @package  Joomla/ORM
 *
 * @since    1.0
 */
class Repository implements RepositoryInterface
{
	/** @var  string  The name (type) of the entity */
	private $entityName;

	/** @var DataMapperInterface */
	private $dataMapper;

	/**
	 * Constructor
	 *
	 * @param   string               $entityName The name (type) of the entity
	 * @param   DataMapperInterface  $dataMapper The builder
	 */
	public function __construct($entityName, DataMapperInterface $dataMapper)
	{
		$this->entityName = $entityName;
		$this->dataMapper = $dataMapper;
	}

	/**
	 * Find an entity using its id.
	 *
	 * getById() is a convenience method, It is equivalent to
	 * ->getOne()->with('id', \Joomla\ORM\Finder\Operator::EQUAL, '$id)->get()
	 *
	 * @param   mixed $id The id value
	 *
	 * @return  object  The requested entity
	 *
	 * @throws  EntityNotFoundException  if the entity does not exist
	 * @throws  OrmException  if there was an error getting the entity
	 */
	public function getById($id)
	{
		return $this->dataMapper->getById($id);
	}

	/**
	 * Find a single entity.
	 *
	 * @return  EntityFinderInterface  The responsible Finder object
	 *
	 * @throws  OrmException  if there was an error getting the entity
	 */
	public function findOne()
	{
		return $this->dataMapper->findOne();
	}

	/**
	 * Find multiple entities.
	 *
	 * @return  CollectionFinderInterface  The responsible Finder object
	 *
	 * @throws  OrmException  if there was an error getting the entities
	 */
	public function findAll()
	{
		return $this->dataMapper->findAll();
	}

	/**
	 * Adds an entity to the repo
	 *
	 * @param   object $entity The entity to add
	 *
	 * @return  void
	 *
	 * @throws  OrmException  if the entity could not be added
	 */
	public function add($entity)
	{
		if (empty($entity->id))
		{
			$this->dataMapper->insert($entity);
		}
		else
		{
			$this->dataMapper->update($entity);
		}
	}

	/**
	 * Deletes an entity from the repo
	 *
	 * @param   object $entity The entity to delete
	 *
	 * @return  void
	 *
	 * @throws  OrmException  if the entity could not be deleted
	 */
	public function delete($entity)
	{
		$this->dataMapper->delete($entity);
	}

	/**
	 * Persists all changes
	 *
	 * @return void
	 */
	public function commit()
	{
		$this->dataMapper->commit();
	}
}
