<?php
RuntimeManager::Instance()->InitializeRuntime();
// $runtime = new \NetPhp\Core\NetPhpRuntime('COM', '{2BF990C8-2680-474D-BDB4-65EEAEE0015F}');

// COM EXAMPLE #1 FROM http://php.net/manual/en/class.com.php
$word = \wd\Microsoft\Office\Interop\Word\netApplicationClass::ApplicationClass_Constructor();

echo "Loaded Word, version {$word->Version()->Val()} </br>";

$word->Visible(TRUE);

// The add method is not visible in the PHP model
// because it contains reference parameters, but you can still
// use it.
$word->Documents()->Add();

$word->Selection()->TypeText("This is a test...");

$word->Quit();

$word = NULL;
?>