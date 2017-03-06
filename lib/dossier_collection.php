<?php

	/****************************************************************************************
	*	Cette classe a été téléchargé légalement pour être utilisée dans le projet.			*
	*	C'est une classe technique qui permet d'insérer des objets dans une collection		*
	*	Des commentaires ont été ajoutés pour plus de compréhension.						*
	*****************************************************************************************/
 

class Collection implements Iterator
{
  private $sClassName;
  private $aoElt;
  
  public function __construct( $sClassName = '')
  {
    $this->sClassName = $sClassName;
    $this->aoElt      = array();
  }
  
  /**
  function adding element to collection and checking consistency of the data
  **/  
  public function add( $oElt )
  {
    if( !is_object($oElt) )
    {
      throw new Exception('Invalid Parameter : [oElt] is not an object.');
    }
    else
    {
      if( empty($this->sClassName) ) 
      {
        $this->sClassName = get_class($oElt);
      }
      if( is_a( $oElt, $this->sClassName) )
      {
        $this->aoElt[] = $oElt;
      }
      else
      {
        throw new Exception('Invalid Parameter : parameter class mismatch with collection.');
      }
      return $this;
    }
  }
  
  /**
   Magic function in order to intercept all callback and check if called method exists
  **/  
  public function __call( $sMethod, $aParams )
  {
    if( 0 < count($this->aoElt) )
    {
      $oElt = $this->reset();      
      if( method_exists( $oElt, $sMethod ) )
      { 
        foreach( $this->aoElt as $oElt ) 
        {
          call_user_func_array( array( $oElt,$sMethod), $aParams );
        }
      }
      else
      {
        throw new Exception('Invalid call : the method ['.$sMethod.'] is not defined in class ['.$this->sClassName.'].');
      }
    }    
  }
  
  
  /**
  functions simulated array comportement
  **/
  public function reset()
  {
    return reset($this->aoElt);
  }
  
  public function count()
  {
	return count($this->aoElt);
  }
  
  public function next()
  {
    return next($this->aoElt);
  }

  public function prev()
  {
    return prev($this->aoElt);
  }

  public function current()
  {
    return current($this->aoElt);
  }

  public function end()
  {
    return end($this->aoElt);
  }  
  
  public function each()
  {
    return each($this->aoElt);
  }
  
 /**
  functions implemented for Iterator
  **/
  public function key()
  {
    return key($this->aoElt);
  }
  
  public function rewind()
  {
    $this->reset();
  }
  
  public function valid()
  {
    return ( false !== $this->current() );
  }
}

?>
