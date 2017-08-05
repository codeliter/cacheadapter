CacheAdapter
=============================================
This library does not implement any functionality on its own it is written to help communicate better with the Nettecache library.
It is only an adapter that streamlines caching using the file storage. 

###Requirements
- Php >= 5.4

- Composer

###Installation
- Open your default terminal program

- Change your working directory to the project directory you wish to use this library in.

    You can run the following the command on mac/linux.
   ```
   cd /var/www/html/<project-directory>
  ```
  *<project-directory>* is where your project lives in


- Run the command to import the library
    ```
    composer require codeliter/cacheadapter
    ```
    
- That's all

###Usage
Using this library can be as easy as:
    
* Initialize the Cache Library and set the absolute or relative path of where you want the cache to be saved to

        $cache = new Codeliter\CacheAdapter\Cache('./data/cache');
        
* You can save anything to Cache like this
           
        $cache_name = 'test_cache';
        $data = 'This is the content of the test_case';
        $cache->save($cache_name, $data, '4 Hours');
        
* You can get anything from the Cache
        $cache_name = 'test_cache';
        $data = $cache->get($cache_name);
        
* You can delete from Cache

        $cache_name = 'test_cache';
        $cache->delete($cache_name);
        
        
* A typical use would be
    - Make an API or database request and store it in the cache for as long as the data would
    not change
    
            $cache_name = 'google_home_page';
            
            try {
                // Check if the data already exists
                $data = $cache->get($cache_name);
            }
            catch (Throwable $t) {
                // If data does not exist
                // Make the API or Database request
                $request = file_get_contents('https://google.com');
                // Store the data to cache for sometime for future requests
                $cache->save($cache_name, $request, '24 Hours');
            }
            
            
            
##Credits
- [David Grudl](https://davidgrudl.com/)
    
        




