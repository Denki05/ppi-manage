<?php
    $runtime = new NetPhp\Core\NetPhpRuntime('COM', '{2BF990C8-2680-474D-BDB4-65EEAEE0015F}');
    $runtime->Initialize();

    $runtime->RegisterNetFramework2();

    $datetime = $runtime->TypeFromName("System.DateTime");
    $datetime->Instantiate();
    echo $datetime->ToShortDateString()->Val();
?>