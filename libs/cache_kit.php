<?php
class acmeCache{ 

 // public functionality, acmeCache::fetch() and acmeCache::save()
 // =========================

 function fetch($name, $refreshSeconds = 0){
  global $configuracion;
  if(!$GLOBALS['cache_active']){
	  if(!$configuracion['cache_active'])
		return false; 
  }
  if(!$refreshSeconds) $refreshSeconds = 60; 
  $cacheFile = acmeCache::cachePath($name); 
  if(file_exists($cacheFile) and
   ((time()-filemtime($cacheFile))< $refreshSeconds)) 
   $cacheContent = file_get_contents($cacheFile);
  return $cacheContent;
 } 
 
 function save($name, $cacheContent){
  global $configuracion;
  if(!$GLOBALS['cache_active']){
	  if(!$configuracion['cache_active'])
		return false; 
  } 
  $cacheFile = acmeCache::cachePath($name);
  acmeCache::savetofile($cacheFile, $cacheContent);
 } 
 
 function modified_time($name){
	 $cacheFile = acmeCache::cachePath($name);
	 return time() - filemtime($cacheFile);
 }

 // for internal use 
 // ====================
 function cachePath($name){
	 global $configuracion;
  $cacheFolder = $GLOBALS['cache_folder'];
  if(!$cacheFolder) $cacheFolder = $configuracion['cache_dir'];
  return $cacheFolder . md5(strtolower(trim($name))) . '.cache';
 }
 
 function savetofile($filename, $data){
  $dir = trim(dirname($filename),'/').'/'; 
  //acmeCache::forceDirectory($dir); 
  if(file_exists($filename))	unlink($filename);
  $file = fopen($filename, 'w');
  fwrite($file, $data); fclose($file);
  
 } 
  
 function forceDirectory($dir){ // force directory structure 
  return is_dir($dir) or (acmeCache::forceDirectory(dirname($dir)) and mkdir($dir, 0777));
 }

}
?>
