<?php


namespace HS\libs\collection;


use ArrayAccess;
use Iterator;

class Collection implements ArrayAccess, Iterator, \Countable
{
    protected $items;

    /**
     * Constructor.
     * @param array|null $items
     * @throws CollectionException <br/>
     * Ocurre si el tipo de <var>$items</var> no es <var>array</var> o <var>NULL</var>.
     */
    public function __construct(array &$items = null)
    {
        if (is_null($items))
            $this->items = [];
        else if (is_array($items))
            $this->items = &$items;
        else
            throw new CollectionException('Tipo de dato no apto para ser una colección.', CollectionException::INVALID_COLLECTION);
    }

    #Obtener el array de todos los elementos de la coleccion.

    /**
     * @return array Devuelve una copia del array interno de la colección.
     */
    public function GetInnerArray(): array
    {
        return $this->items;
    }

    #Modificar elementos de la coleccion.
    /**
     * Añade un elemento a la coleccion.<br/><br/>
     * Si <var>$value</var> es un array, lo convierte a <var>Collection</var> antes de almacenarlo.
     * @param string | int $key
     * @param mixed $value
     */
    function Add($key, $value): void
    {
        $this[$key] = $value;
    }

    /**
     * Añade todos los elementos de un arreglo o coleccion, a la coleccion actual.
     * @param array | Collection $items
     * @throws CollectionException <br/>
     * Ocurre si el tipo de <var>$items</var> no es <var>array</var> o <var>Collection</var>
     */
    function AddRange($items): void
    {
        if (is_array($items) || self::IsCollection($items)) {
            foreach ($items as $key => $value) $this[$key] = $value;
        } else
            throw new CollectionException('Tipo de dato no apto para utilizarse como colección.', CollectionException::INVALID_ITEM);
    }

    /**
     * Remueve el elemento con la clave especificada de la Colección.
     * @param int | string $key
     */
    function Remove($key): void
    {
        unset($this[$key]);
    }

    /**
     * Remueve todos los elementos de una colección a la colección actual.
     * @param array | Collection $items
     * @throws CollectionException <br/>
     * Ocurre si el tipo de <var>$items</var> no es <var>array</var> o <var>Collection</var>
     */
    function RemoveRange($items): void
    {
        if (is_array($items) || self::IsCollection($items)) {
            foreach ($items as $key => $value) {
                if (isset($this[$key]) && $this[$key] === $value)
                    unset($this[$key]);
            }
        } else
            throw new CollectionException('Tipo de dato no apto para utilizarse como colección.', CollectionException::INVALID_ITEM);
    }

    /**
     * Remueve todos los elementos de la colección.
     */
    function Clear(): void
    {
        unset($this->items);
        $this->items = [];
    }

    #Acceso a elementos de la coleccion.

    /**
     * Obtiene el elemento con la clave especificada de la Colección.
     * @param int | string $key
     * @return mixed
     * @throws CollectionException <br/>
     * Ocurre si no existe la clave especificada dentro de la colección.
     */
    public function GetItem($key)
    {
        return $this[$key];
    }

    /**
     * Devuelve el primer elemento de la colección.
     * @return mixed | null
     * Devuelve <var>NULL</var> si la colección esta vacia.
     */
    public function First()
    {
        return empty($this->items) ? null : $this[array_key_first($this->items)];
    }

    /**
     * Devuelve el ultimo elemento de la colección.
     * @return mixed | null
     * Devuelve <var>NULL</var> si la colección esta vacia.
     */
    public function Last()
    {
        return empty($this->items) ? null : $this[array_key_last($this->items)];
    }

    #Estado de la coleccion.
    public function GetLenght(): int
    {
        return count($this->items);
    }

    public function IsEmpty(): bool
    {
        return empty($this->items);
    }

    #Implementacion de los metodos magicos para utilizar dinamicamente elementos del array.
    public function __get($name)
    {
        return $this[$name];
    }

    public function __set($name, $value): void
    {
        $this[$name] = $value;
    }

    public function __isset($name): bool
    {
        return isset($this[$name]);
    }

    public function __unset($name): void
    {
        unset($this[$name]);
    }

    #Implementacion de la interfaz "ArrayAccess".
    public function offsetExists($offset): bool
    {
        return isset($this->items[$offset]);
    }

    /**
     * @param int | string $offset
     * @return mixed
     * @throws CollectionException <br/>
     * Ocurre si no existe la clave especificada dentro de la colección.
     */
    public function offsetGet($offset)
    {
        if ((is_int($offset) || is_string($offset)) && isset($this->items[$offset]))
            return $this->items[$offset];
        else
            throw new CollectionException("La clave \"$offset\" no existe dentro de la Colección.", CollectionException::UNDEFINED_OFFSET);
    }

    public function offsetSet($offset, $value)
    {
        if (is_null($offset))
            $this->items[] = self::GetValue($value);
        else
            $this->items[$offset] = self::GetValue($value);
    }

    public function offsetUnset($offset)
    {
        unset($this->items[$offset]);
    }

    #Implementacion de la interfaz "Iterator".
    public function current()
    {
        return current($this->items);
    }

    public function next()
    {
        return next($this->items);
    }

    public function key()
    {
        return key($this->items);
    }

    public function valid(): bool
    {
        $key = Key($this->items);
        return !is_null($key) && isset($this->items[$key]);
    }

    public function rewind()
    {
        reset($this->items);
    }

    #Implementacion de la interfaz "Countable".
    public function count()
    {
        return \count($this->items);
    }

    #Metodos publicos estaticos.
    public function IsCollection($object): bool
    {
        return get_class($object) == Collection::class;
    }

    #Metodos privados y estaticos.

    /**
     * Obtiene el valor real a almacenar dentro de la coleccion.
     * @param mixed $value
     * @return Collection | mixed
     */
    private static function GetValue($value)
    {
        try {
            return is_array($value) ? new Collection($value) : $value;
        } catch (CollectionException $ex) {
            return null; //¡¡¡ESTA LINEA NUNCA SE EJECUTARA!!! >.<
        }
    }
}