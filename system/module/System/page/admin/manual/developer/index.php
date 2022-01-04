<script>
    function view(id){
        if(S("#" + id)){
            S.all(".hide", function(el){el.style.display = 'none';});
            if(location.hash != id){location.hash = id;}
        S("#" + id).style.display = 'block';
        }
        S.toggle("." + id + "-menu");
    }
</script>

<div class="column-2">
    <?php
        require_once(\system\Core::doc_root() . "/system/module/System/php/ManualAPP.php");
        $ManualAPP = new \module\System\ManualAPP;
        $start_path = dirname(__FILE__);
    ?>

    <ul class="manual-menu">
        <li class="menu-item"><a onclick="view('introduction')">Introduction</a></li>
        <li class="menu-item"><a onclick="view('convention')">Convention</a></li>
        <li class="menu-item"><a onclick="view('structure')">Structure</a></li>
        <li class="menu-item with-sub">
            <a onclick="view('system')">System</a>
            <?php echo $ManualAPP->menu($start_path . "/system");?>
        </li>
        <li class="menu-item with-sub">
            <a onclick="view('module')">Module</a>
            <?php echo $ManualAPP->menu($start_path . "/module");?>
        </li>
        <li class="menu-item"><a onclick="view('plugin')">Plugin</a></li>
        <li class="menu-item"><a onclick="view('web')">Web</a></li>
        <li class="menu-item"><a onclick="view('data')">Data</a></li>
        <li class="menu-item"><a onclick="view('security')">Security</a></li>
    </ul>

</div>


<div class="column-10 padding-20 manual-content">


<!-- HOME -->
    <div id="home" class="hide block text-center">
        <h1>ImaSmi Web</h1>
        <h2>Developer manual</h2>
        <h2>Author: Mihail Tarlyovski</h2>
    </div>

    <?php
        foreach(\system\Core::list_dir($start_path, array("select" => "file")) as $key => $path){
            $name = basename($key);
            if($name != "index.php"){
            ?>
                <div id="<?php echo $ManualAPP->path_id($path, count(explode('/', $start_path)) - count(explode('/', $path)));?>" class="hide"><?php include_once($path);?></div>
            <?php
            }
        }
    ?>

</div>

<script>
    if(window.location.hash) {
        var loc = location.hash;
        view(loc.slice(1));
    }
</script>
