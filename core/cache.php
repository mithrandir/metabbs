<?php
//	Usage : 
//	$cache = new PageCache;
//	$cache->name = strtoupper('test');
//	if($cache->load()) { //If successful loads
//		return $cache->contents;
//	}
//	ob_start();
//	.. contents ..
//	$ob = ob_get_contents();
//	ob_end_clean();
//	$cache->contents = $ob;
//	$cache->update();
//	unset($cache);
//	return $ob;

class PageCache {
	var $name, $contents;
	protected $lifetime, $fp, $locked, $cachedir;

	public function PageCache($cachedir = 'data') {
		$this->contents = null;
		$this->cachedir = $cachedir;
		if(!file_exists($this->cachedir."/page_cache")) {
			mkdir($this->cachedir."/page_cache");
			chmod($this->cachedir."/page_cache", 0707);
		}
	}

	public function load($lifetime=300, $forceRefresh=false) {
		global $config;

		if (empty($this->name)) return false;

		if (isset($config->use_page_cache) && !$config->use_page_cache)
			return true;

		$this->lifetime = $lifetime;
		if(!$forceRefresh && $this->isCacheValid()) {
			$this->contents = @file_get_contents($this->cachedir."/page_cache/{$this->name}");
			return true;
		}
		if($this->fp = fopen($this->cachedir."/page_cache/{$this->name}.tmp", 'w')) {
			if(!($this->locked = flock($this->fp, LOCK_EX + LOCK_NB, $wouldblock)) && $wouldblock == 0) {
				$this->contents = @file_get_contents($this->cachedir."/page_cache/{$this->name}");
				$this->unlock();
				return true;
			}
		}
		return false;
	}

	public function update($writeTimestamp=true) {
		global $config;

		if (empty($this->name)) return false;

		if (isset($config->use_page_cache) && !$config->use_page_cache)
			return true;

		if($this->fp && $this->locked) {
			fwrite($this->fp, $this->contents);
			if($writeTimestamp)
				fwrite($this->fp, "\r\n".'<!-- cached on '.date('r').' -->');
			fclose($this->fp);
			@copy($this->cachedir."/page_cache/{$this->name}.tmp", $this->cachedir."/page_cache/{$this->name}");
		}
	}
	
	public function purge() {
		global $config;

		if (empty($this->name)) return false;

		if (isset($config->use_page_cache) && !$config->use_page_cache)
			return true;

		@unlink($this->cachedir."/page_cache/{$this->name}.tmp");
		@unlink($this->cachedir."/page_cache/{$this->name}");
		return true;
	}

	protected function unlock() {
		@flock($this->fp, LOCK_UN);
		@fclose($this->fp);
		$this->fp = $this->locked = false;
	}

	protected function isCacheValid() {
		clearstatcache();
		return (file_exists($this->cachedir."/page_cache/{$this->name}") && ((time() - filemtime($this->cachedir."/page_cache/{$this->name}")) < $this->lifetime));
	}
}
?>