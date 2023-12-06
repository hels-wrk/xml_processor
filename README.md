<h1>XML Processor</h1>

 <h2>Setup project:</h2>

<ul>
  <li>git clone https://github.com/hels-wrk/xml_processor.git</li>
  <li>cd xml_processor</li>
  <li>docker-compose build</li>
  <li>docker-compose up -d</li>
  <li>docker-compose exec php composer install</li>
  <li>docker-compose exec php bin/console doctrine:migrations:migrate</li>
</ul>
 
 <h2>Using the command</h2>
  <pre><code>
  docker-compose exec php bin/console import:xml
</code></pre>  

<h2>Tests:</h2>

  <pre><code>
  docker-compose exec php vendor/bin/phpunit
</code></pre>  
