# Spot2 Mapper -> API

### Quellen:

+ http://phpdatamapper.com/docs/relations/  
+ https://github.com/vlucas/spot2


### Initialisierung

	// Konfiguration ORM
    $configSpot = new \Spot\Config();
    $configSpot->addConnection('mysql','mysql://test:test@localhost/test');

    /** @var $spot \Spot\Locator */
    $spot = new \Spot\Locator($configSpot);

	$mapperTest = $spot->mapper('entity\test');

### $mapperTest->all()
abrufen aller Datensätze in einer Entity

	$result = $mapperTest->all()->toArray();

### $mapperTest->insert()
einfügen eines Datensatzes in eine Entity

	// insert
    $insert = ['name' => 'Matthias', 'vorname' => 'Krauss'];
	$mapperTest->create($insert);

### $mapperTest->get()

The get method accepts a primary key to load a record with

	// Get Post with 'id' = 58
	$mapper = $spot->mapper('Entity\Post');
	$post = $mapper->get(58);

### $mapperTest->belongsTo()

### $mapperTest->build()

Build an entity object with the provided array data.

	$entity = $mapper->build([
	    'name' => 'Chester Tester',
	    'email' => 'chester@example.com'
	]);

### $mapperTest->collection()

### $mapperTest->collectionClass()

### $mapperTest->config()

### $mapperTest->connections()

### $mapperTest->create()

Create will both build and insert the entity. The result will be a fully-loaded entity object that has already been saved.

	// Returns a successfully saved, loaded Entity\User object... or throws an exception
	$entity = $mapper->create([
	    'name' => 'Chester Tester',
	    'email' => 'chester@example.com'
	]);

### $mapperTest->delete()

### $mapperTest->dropTable()

### $mapperTest->entity()

### $mapperTest->entityManager()

### $mapperTest->eventEmitter()

### $mapperTest->fieldExists()

### $mapperTest->fieldInfo()

### $mapperTest->fields()

### $mapperTest->fieldsDefined()

### $mapperTest->fieldType()

### $mapperTest->first()

Find and return a single Spot\Entity object that matches the criteria.

	$post = $mapper->first(['title' => "Test Post"]);

Or first can be used on a previous query with where to fetch only the first matching record.

	$post = $mapper->where(['title' => "Test Post"])->first();

A call to first will always execute the query immediately, and return either a single loaded entity object, or boolean false.

### mapperTest->get()

Find all entities that match the given conditions and return a Spot\Entity\Collection of loaded Entity\Post objects.

	$mapper = $spot->mapper('Entity\Post');

	// Where can be called directly from the mapper
	$posts = $mapper->where(['status' => 1]);

	// Or chained using the returned `Spot\Query` object - results identical to above
	$posts = $mapper->all()->where(['status' => 1]);

	// Or more explicitly using using `select`, which always returns a `Spot\Query` object
	$posts = $mapper->select()->where(['status' => 1]);

A Spot\Query object is returned with all queries, which means additional conditions and other statements can be chained in any way or order you want. The query will be lazy-executed on interation or count, or manually by ending the chain with a call to execute().

#### Conditional Variations

	// All posts with a 'published' status, descending by date_created
	$posts = $mapper->all()
	    ->where(['status' => 'published'])
	    ->order(['date_created' => 'DESC']);

	// All posts created before 3 days ago
	$posts = $mapper->all()
	    ->where(['date_created <' => new \DateTime('-3 days')]);

	// Posts with 'id' of 1, 2, 5, 12, or 15 - Array value = automatic "IN" clause
	$posts = $mapper->all()
	    ->where(['id' => [1, 2, 5, 12, 15]]);



### $mapperTest->getMapper()

### $mapperTest->hasMany()

### $mapperTest->hasManyThrough()

### $mapperTest->hasOne()

### $mapperTest->insert()

The insert method will create a new row in the database with the provided data (either an array of data, or a Spot\Entity object), and will return either the inserted record’s primary key, or boolean false.

	// Insert and return record primary key, or boolean false
	$result = $mapper->insert([
	    'name' => 'Chester Tester',
	    'email' => 'chester@example.com'
	]);

	// Fetch inserted record by ID
	if ($result) {
	    $entity = $mapper->get($result);
	}

You can also pass a Spot\Entity object to insert

	// Insert and return record primary key, or boolean false
	$entity = $mapper->build([
	    'name' => 'Chester Tester',
	    'email' => 'chester@example.com'
	]);

	$result = $mapper->insert($entity);
	// Fetch inserted record by ID
	if ($result) {
	    // Do something with $entity
	}


### $mapperTest->loadEvents()

### $mapperTest->loadRelations()

### $mapperTest->migrate()
Spot comes with a method for running migrations on Entities that will automatically CREATE and ALTER tables based on the current Entity’s fields definition.

	$mapper = $spot->mapper('Entity\Post');
	$mapper->migrate();

Your database should now have the posts table in it, with all the fields you described in your Post entity.


### $mapperTest->prepareEntity()

### $mapperTest->primaryKey()

### $mapperTest->query()

### $mapperTest->queryBuilder()

### $mapperTest->queryClass()

### $mapperTest->relations()

### $mapperTest->resolver()

### $mapperTest->save()

Build will create the Entity object for you, but it will not save it. If you also wish to save the entity object, you must pass it to one of the save methods.

	// Save and return record primary key, or boolean false
	$entity = $mapper->build([
	    'name' => 'Chester Tester',
	    'email' => 'chester@example.com'
	]);

	$result = $mapper->save($entity);

	// Fetch inserted record by ID
	if ($result) {
	    // Update with another call to save
	    $entity->name = 'Lester Tester';
	    $mapper->save($entity);
	}

### $mapperTest->saveBelongsToRelations()

### $mapperTest->saveHasRelations()

### $mapperTest->scopes()

### $mapperTest->select()

To get an instance of the query builder (Spot\Query) with no conditions set on it, use select.

	// Get instance of the query builder directly
	$query = $mapper->select();

This is effectively the same thing as all(), but without any semantics attached.


### $mapperTest->table()

### $mapperTest->transaction()

### $mapperTest->truncateTable()

### $mapperTest->update()

The update method will update an existing entity.

	// Find and update an entity
	$entity = $mapper->first(['email' => 'chester@example.com']);
	if ($entity) {
	    $entity->name = 'Lester Tester';
	    $mapper->update($entity);
	}

### $mapperTest->upsert()

### $mapperTest->validate()

### $mapperTest->where()










