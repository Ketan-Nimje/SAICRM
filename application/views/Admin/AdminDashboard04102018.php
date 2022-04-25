
      <!-- Different data widgets --> 
      <!-- ============================================================== -->
      <div class="row">
        <div class="col-sm-12">
          <div class="white-box">
            <div class="row row-in">
              <p style="font-size:26px">This Month Data ( <?php echo date('F-Y');?> )
              <p>
              <div class="col-lg-3 col-sm-6 row-in-br">
                <ul class="col-in">
                  <!--li> <span class="circle circle-md bg-danger"><i class="ti-clipboard"></i></span> </li-->
                  <li class="col-last">
                    <h3 class="counter text-right m-t-15"><?php echo $Installation[0]['total'];  ?></h3>
                  </li>
                  <li class="col-middle">
                    <h4>Installation</h4>
                    <div class="progress">
                      <div class="progress-bar progress-bar-danger" role="progressbar" aria-valuenow="40" aria-valuemin="0" aria-valuemax="100" style="width: 40%"> <span class="sr-only">40% Complete (success)</span> </div>
                    </div>
                  </li>
                </ul>
              </div>
              <div class="col-lg-3 col-sm-6 row-in-br  b-r-none">
                <ul class="col-in">
                  <!--li> <span class="circle circle-md bg-info"><i class="ti-wallet"></i></span> </li-->
                  <li class="col-last">
                    <h3 class="counter text-right m-t-15"><?php echo  $Updatation[0]['total']; ?></h3>
                  </li>
                  <li class="col-middle">
                    <h4>Updatation</h4>
                    <div class="progress">
                      <div class="progress-bar progress-bar-info" role="progressbar" aria-valuenow="40" aria-valuemin="0" aria-valuemax="100" style="width: 40%"> <span class="sr-only">40% Complete (success)</span> </div>
                    </div>
                  </li>
                </ul>
              </div>
              <div class="col-lg-3 col-sm-6 row-in-br">
                <ul class="col-in">
                  <!--li> <span class="circle circle-md bg-success"><i class=" ti-shopping-cart"></i></span> </li-->
                  <li class="col-last">
                    <h4 class="counter text-right m-t-15" title="<?php echo $LANTR[0]['lantr']." LanTr and ".$LANN[0]['lann']." Lan";?>">
          <?php echo $LANTR[0]['lantr']." LanTr + ".$LANN[0]['lann']." Lan"; ?> </h4>
                    <h3 class="counter text-right m-t-15"></h3>
                  </li>
                  <li class="col-middle">
                    <h4>LAN  = <?php echo intval($LANTR[0]['lantr']) + intval($LANN[0]['lann']); /*$LAN[0]['total']*/ ?></h4>
                    <div class="progress">
                      <div class="progress-bar progress-bar-success" role="progressbar" aria-valuenow="40" aria-valuemin="0" aria-valuemax="100" style="width: 40%"> <span class="sr-only">40% Complete (success)</span> </div>
                    </div>
                  </li>
                </ul>
              </div>
              <div class="col-lg-3 col-sm-6  b-0">
                <ul class="col-in">
                  <!--li> <span class="circle circle-md bg-warning"><i class="fa fa-dollar"></i></span> </li-->
                  <li class="col-last">
                    <h3 class="counter text-right m-t-15"><?php echo $Conversion[0]['total']; ?></h3>
                  </li>
                  <li class="col-middle">
                    <h4>Conversion</h4>
                    <div class="progress">
                      <div class="progress-bar progress-bar-warning" role="progressbar" aria-valuenow="40" aria-valuemin="0" aria-valuemax="100" style="width: 40%"> <span class="sr-only">40% Complete (success)</span> </div>
                    </div>
                  </li>
                </ul>
              </div>
            </div>
          </div>
        </div>
      </div>
      <!--row --> 
  
      <!----Year Wise + Product Wise---->
      <div class="row">
        <div class="col-sm-12 ">
          <form>
            <div class="row">
              <div class="col-sm-3 "> Product-Wise
                <select class="form-control" id="product_id" name="p_name">
                  <option value="all" <?php if(!isset($selected['product'])) echo "selected";?> >All</option>
                  <?php
                                    foreach ($product as $p) {  
                                                             $sel="";  
                                                            if($selected['product']==$p['label'])
                                                                $sel="selected";   
                                                            echo "<option value='" . $p['label'] . "'".$sel.">". $p['label'] . "</option>";
                                                            }
                                                       
                                                            ?>
                </select>
              </div>
              <div class="col-sm-2 "> Year-Wise
                <select class="form-control" id="year_id" name="yearname">
                  <option value="all" <?php if(isset($selected['year'])) echo "selected";?> >All Year </option>
                  <?php foreach ($year as $y) { ?>
                  <option value="<?php echo $y['yearname'] ?>"
            <?php echo (date('Y')==$y['yearname'])?"selected='selected'":NULL ?>><?php echo $y['yearname'] ?></option>
                  <?php } ?>
                </select>
              </div>
            </div>
          </form>
        </div>
        <div class="col-sm-12">
          <div class="white-box">
            <div class="row row-in">
              <div class="col-lg-3 col-sm-6 row-in-br">
                <ul class="col-in">
                  <!--li> <span class="circle circle-md bg-danger"><i class="ti-clipboard"></i></span> </li-->
                  <li class="col-last">
                    <h3 class="counter text-right m-t-15" id="Installation_count_wise"><?php //echo $Installation1[0]['total'];  ?></h3>
                  </li>
                  <li class="col-middle">
                    <h4>Installation</h4>
                    <div class="progress">
                      <div class="progress-bar progress-bar-danger" role="progressbar" aria-valuenow="40" aria-valuemin="0" aria-valuemax="100" style="width: 40%"> <span class="sr-only">40% Complete (success)</span> </div>
                    </div>
                  </li>
                </ul>
              </div>
              <div class="col-lg-3 col-sm-6 row-in-br  b-r-none">
                <ul class="col-in">
                  <!--li> <span class="circle circle-md bg-info"><i class="ti-wallet"></i></span> </li-->
                  <li class="col-last">
                    <h3 class="counter text-right m-t-15" id="Updatation_count_wise"><?php //echo $Updatation1[0]['total']; ?></h3>
                  </li>
                  <li class="col-middle">
                    <h4>Updatation</h4>
                    <div class="progress">
                      <div class="progress-bar progress-bar-info" role="progressbar" aria-valuenow="40" aria-valuemin="0" aria-valuemax="100" style="width: 40%"> <span class="sr-only">40% Complete (success)</span> </div>
                    </div>
                  </li>
                </ul>
              </div>
              <div class="col-lg-3 col-sm-6 row-in-br">
                <ul class="col-in">
                  <!--li> <span class="circle circle-md bg-success"><i class=" ti-shopping-cart"></i></span> </li-->
                  <li class="col-last">
                    <h4 class="counter text-right m-t-15" id="LAN_count_wise"><?php //echo $LAN1[0]['total']; ?></h4>
                  </li>
                  <li class="col-middle">
                    <h4 id="LAN_count_wise1">LAN</h4>
                    <div class="progress">
                      <div class="progress-bar progress-bar-success" role="progressbar" aria-valuenow="40" aria-valuemin="0" aria-valuemax="100" style="width: 40%"> <span class="sr-only">40% Complete (success)</span> </div>
                    </div>
                  </li>
                </ul>
              </div>
              <div class="col-lg-3 col-sm-6  b-0">
                <ul class="col-in">
                  <!--li> <span class="circle circle-md bg-warning"><i class="fa fa-dollar"></i></span> </li-->
                  <li class="col-last">
                    <h3 class="counter text-right m-t-15" id="Conversion_count_wise"><?php //echo $Conversion1[0]['total']; ?></h3>
                  </li>
                  <li class="col-middle">
                    <h4>Conversion</h4>
                    <div class="progress">
                      <div class="progress-bar progress-bar-warning" role="progressbar" aria-valuenow="40" aria-valuemin="0" aria-valuemax="100" style="width: 40%"> <span class="sr-only">40% Complete (success)</span> </div>
                    </div>
                  </li>
                </ul>
              </div>
            </div>
          </div>
        </div>
      </div>
      
      <!----Year Wise + Product Wise----> 