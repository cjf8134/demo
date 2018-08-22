<?php
class fileCache
{
    private $root_dir;
    
    public function __construct ($root_dir)
    {
        $this->root_dir = $root_dir;
        
        if (FALSE == file_exists($this->root_dir))
        {
            mkdir($this->root_dir, 0700, true);
        }
    }
    
    public function set ($key, $value)
    {
        $key = $this->escape_key($key);
        
        $file_name = $this->root_dir . '/' . $key;
        
        $dir = dirname($file_name);
        
        if (FALSE == file_exists($dir))
        {
            mkdir($dir, 0700, true);
        }
        
        file_put_contents($file_name, serialize($value), LOCK_EX);
    }
    
    public function get ($key)
    {
        $key = $this->escape_key($key);
        
        $file_name = $this->root_dir . '/' . $key;
        
        if (file_exists($file_name))
        {
            return unserialize(file_get_contents($file_name));
        }
        
        return null;
    }
    
    public function remove ($key)
    {
        $key = $this->escape_key($key);
        
        $file = $this->root_dir . '/' . $key;
        
        if (file_exists($file))
        {
            unlink($file);
        }
    }
    
    public function remove_by_search ($key)
    {
        $key = $this->escape_key($key);
        
        $dir = $this->root_dir . '/' . $key;
        
        if (strrpos($key, '/') < 0)
            $key .= '/';
        
        if (file_exists($dir))
        {
            $this->removeDir($dir);
        }
    }
    
    private function escape_key ($key)
    {
        return str_replace('..', '', $key);
    }
    
    function removeDir($dirName)
    {
        $result = false;
        
        $handle = opendir($dirName);
        
        while(($file = readdir($handle)) !== false)
        {
            if($file != '.' && $file != '..')
            {
                $dir = $dirName . DIRECTORY_SEPARATOR . $file;
            
                is_dir($dir) ? $this->removeDir($dir) : unlink($dir);
            }
        }
        
        closedir($handle);
        
        rmdir($dirName) ? true : false;
        
        return $result;
    }
}


// $data_1 = array(
//   'u_id' => 1,
//   'name' => '利沙'
// );

// $data_2 = array(
//   'u_id' => 2,
//   'name' => 'WaWa'
// );

// $cache = new fileCache("cache");

// $cache->set("10000036", $data_1);  //保存数据
// $cache->set("user/2/data", $data_2);  //保存数据

// $result = $cache->get("10000036"); //获取数据

// echo '测试如下：<pre>';
// print_r($result);

// //$cache->remove("user/1/data"); //删除数据

// //$cache->remove_by_search("user", $data_1);  //删除user节点下所有数据
