## Entity filter

Filters Doctrine enitites and transformers them into arrays. Examples speak for themselves, so read on.

## Installation

`$ composer require mario-legenda/entity-filter`

## Basic usage

Let's say we have a `User` entity that has 25 fields in that describe a certain user, like name, lastname,
social security number etc. If you want only 10 of those fields, you would have to manually call each and
every method and place them in some variables. Code code is as follows...

```
$user = new User();

$name = $user->getName()
$lastname = $user->getLastname();
... 8 remaining fields
```

This creates some ugly code. If you wish to put the values of those fields in an array, the code is even
uglier.

```
$user = new User();

$userData['name'] = $user->getName();
$userData['lastname'] = $user->getName();
... 8 remainig fields
```

Now, you could say that you can query the database with DQL, but in some cases, you need a clean entity if you
wish to update the databse, for example. This is the situtation where this tool comes in handy.

```
$user = new User();
$entityFilter = new EntityFilter();

$filtered = $entityFilter
               ->setEntity($user)
               ->configure(array(
                   'id', 'name', 'lastname', 'ssn'
               ))
               ->setDataVar('user')
               ->getFiltered();
```

`$filtered` is an array that holds `id`, `name` and other values that you ask from it. `EntityFilter::setDataVar()`
sets the value of an array key that holds the array with the specified values from the User entity. Default
is `data`.

I hope that someone finds this helpfull.



