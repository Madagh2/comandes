<div class="container">
<div class="card">
    <form method="POST" action="comandnou.php" name="comandnou" ENCTYPE="multipart/form-data">
        <h5 class="header <?php echo $colortit;?>"><?php echo (isset($_GET['cid']) ? "Comanda" : "Nova comanda");?></h5>
        <!-- Professorat i dia -->
        <div class="row <?php echo $colorweb;?> lighten-5">
            <div class="input-field col s8 m9 l10">
                <input readonly="" type="text" value="<?php echo $profe;?>" id="profe" name="profe"/>
                <input type="hidden" name="uid" value="<?php echo $uid;?>">
                <label for="profe">Comunicada per</label>
            </div>
            <div class="input-field col s4 m3 l2">
                <input type="text" value="<?php echo date('d/m/Y');?>" id="data" name="data" class="datepicker"/>
                <label for="data">El dia</label>
            </div>
        </div>
        <!-- Departament -->
        <div class="row">
            <div class="input-field col s12">
                <?php if (permis('centre')==1) {?>
                    <select id="departament" name="departament">
                        <option value="<?php echo $departament;?>"><?php echo $departament;?></option>
                        <option value="Centre">Centre</option>
                    </select>
                <?php } else {?>
                    <input type="text" value="<?php echo $departament;?>" readonly="" id="departament" name="departament"/>
                <?php }?>
                <label for="departament">Departament</label>
            </div>
        </div>
        <!-- Curs -->
        <div class="row <?php echo $colorweb;?> lighten-5">
            <div class="input-field col s12">
                <?php $optcurs = array();
                $sqle="SELECT DISTINCT familia FROM oferta ORDER BY familia";
                $querye = mysqli_query($link,$sqle);
                while ($rowe = mysqli_fetch_assoc($querye))
                {
                  $optcurs[] = '<optgroup label="'.$rowe['familia'].'">';
                  $sqlc='SELECT *  FROM oferta WHERE familia="'.$rowe['familia'].'" ORDER BY codi';
                  $queryc = mysqli_query($link,$sqlc);
                  while ($rowc = mysqli_fetch_assoc($queryc))
                  {
                          $opt = '<option value="'.$rowc['codi'].'"';
                          if ($rowc['codi']==$curs) {$opt .=' selected=""';}
                          $opt .='>'.$rowc['codi']." ".$rowc['nom'].'</option>';
                        $optcurs[] = $opt;
                  }
                    $optcurs[] = "</optgroup>";
                }
                $optcurs = join("\n", $optcurs);?>
                <select name="curs" id="curs">
                    <option value="">-</option>
                    <?php echo $optcurs;?>
                </select>
                <label for="curs">Curs</label>
            </div>
        </div>
        <!-- Matèria -->
        <div class="row">
            <div class="input-field col s12">
                <?php $optmod = array();
                $sqle='SELECT DISTINCT departament FROM comanda'.$a;
                $sqle.=(permis('comand')<>1 ? ' WHERE departament="'.$departament.'" OR    ' : ' WHERE ');
                $sqle=(permis('centre')==1 ? $sqle.'departament="Centre"' : substr($sqle, 0, -7));
                $sqle.=" ORDER BY departament";
                $querye = mysqli_query($link,$sqle);
                while ($rowe = mysqli_fetch_array($querye))
                {
                    $optmod[] = '<optgroup label="'.$rowe['departament'].'">';
                    $sqlc='SELECT DISTINCT materia FROM comanda'.$a.' WHERE departament="'.$rowe['departament'].'" ORDER BY materia';
                    $queryc = mysqli_query($link,$sqlc);
                    while ($rowc = mysqli_fetch_array($queryc))
                    {
                        $opt = '<option value="'.$rowc['materia'].'"';
                        if ($rowc['materia']==$materia) {$opt .=' selected=""';}
                        $opt .='>'.$rowc['materia'].'</option>';
                        $optmod[] = $opt;
                    }
                    $optmod[] = "</optgroup>";
                }

                $optmod = join("\n", $optmod);?>
                <select id="materia" name="materia">
                    <option value="">-</option>
                    <?php echo $optmod;?>
                </select> 
                <label for="materia">Mòdul</label>
            </div>
            <div class="input-field col s12">
                <input type="text" value="" id="materiaa" name="materiaa"/>
                <label for="materiaa">Escriu mòdul si no apareix al llistat</label>
            </div>
        </div>
        <!-- Proveïdor -->
        <div class="row <?php echo $colorweb;?> lighten-5">
            <div class="input-field col s12">
                <?php $optprov = array();
                $querye = mysqli_query($link,$sqle);
                
                while ($rowe = mysqli_fetch_assoc($querye))
                {
                    $optprov[] = '<optgroup label="'.$rowe['departament'].'">';
                    $sqlc="SELECT DISTINCT proveidor FROM comanda".$a." WHERE departament='".$rowe['departament']."' ORDER BY proveidor";
                    $queryc = mysqli_query($link,$sqlc);
                    while ($rowc = mysqli_fetch_assoc($queryc))
                    {
                        $opt = '<option value="'.$rowc['proveidor'].'"';
                        if ($rowc['proveidor']==$proveidor) {$opt .=' selected=""';}
                        $opt .='>'.$rowc['proveidor'].'</option>';
                        $optprov[] = $opt;
                    }
                    $optprov[] = "</optgroup>";
                }

                $optprov = join("\n", $optprov);?>
                <select id="proveidor" name="proveidor">
                    <option value="">-</option>
                    <?php echo $optprov;?>
                </select> 
                <label for="proveidor">Proveïdor</label>
            </div>
            <div class="input-field col s12">
                <input type="text" value="" name="proveidora" id="proveidora"/>
                <label for="proveidora">Escriu proveïdor si no apareix al llistat</label>
            </div>
        </div>
        <!-- Full de comanda adjunt -->
        <div class="row">
            <?php $btf="Full de comanda";
            if ($adjunt!="") {
                $btf="Substituir";?>
                <div>
                    <a href="adjunts/comandes/<?php echo $adjunt;?>" target="blank"><i class="material-icons" title="Full de comanda detall" alt="Full de comanda detall">file_present</i> Full de comanda adjuntat</a>
                    <i class="material-icons right pointer <?php echo $colortit;?>" onclick="location.href='comandadjesb.php?cid=<?php echo $cid;?>'">delete</i>
                </div>
                <br>
            <?php }?>
            <div class="file-field input-field col s12">
                <div class="btn <?php echo $colorbut;?>">
                    <span><?php echo $btf;?></span>
                    <input type="file" name="archivo" id="archivo" accept="application/pdf">
                </div>
                <div class="file-path-wrapper">
                    <input class="file-path validate" type="text" id="archivon">
                    <label for="archivon">Adjuntar full de comanda</label>
                </div>
            </div>
        </div>
        <div class="row <?php echo $colorweb;?> lighten-5">
            <div class="input-field col s12 center">
                <input type="hidden" name="cid" value="<?php echo $cid;?>">
                <button class="btn waves-effect waves-light <?php echo $colorbut;?>" type="submit" name="action"><i class="material-icons right">send</i><?php echo $st;?></button>
            </div>
        </div>
    </form>
</div>
</div>