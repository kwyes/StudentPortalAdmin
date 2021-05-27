<?php
  $page = $_GET['page'];
  $boardingautharr = array(30,31,32);
  $adminautharr = array(10,21,30,31,32,99);
//   $bogs = $_SESSION['bogs'];
  $bogs = 'yes';
 ?>
<div class="sidebar" data-active-color="blue" data-background-color="black">
    <!--
      Tip 1: You can change the color of active element of the sidebar using: data-active-color="purple | blue | green | orange | red | rose"
      Tip 2: you can also add an image using data-image tag
      Tip 3: you can change the color of the sidebar with data-background-color="white | black"
  -->

    <div class="logo">
        <a href="?page=dashboard" class="simple-text logo-mini">

        </a>

        <a href="?page=dashboard" class="simple-text logo-normal">
            SP Admin (Beta)
        </a>
    </div>

    <div class="sidebar-wrapper">
        <ul class="nav">

            <li class="<?php echo ($page=='' || $page=='dashboard')?" active":"";?>">
                <a href="?page=dashboard">
                    <i class="material-icons-outlined">dashboard</i>
                    <p> Dashboard </p>
                </a>
            </li>
            <?php if($bogs == 'yes') { ?>
            <li class="bogsList <?php echo ($page=='bogs')?" active":"";?>">
                <a class="nav-link bogsMainMenu" data-toggle="collapse" href="#bogsMenu">
                    <i class="material-icons">flag</i>
                    <p> BOGS <b class="caret"></b></p>
                </a>
                <div class="collapse" id="bogsMenu">
                    <ul class="nav bogsSubMenu">
                        <li class="nav-item <?php echo ($menu=='semester')?" active":"";?>">
                        <a class="nav-link" href="?page=bogs&menu=semester">
                            <span class="sidebar-mini"> SC </span>
                            <span class="sidebar-normal"> Semester Config</span>
                        </a>
                        </li>
                        <?php if($_SESSION['bogsSemester']) { ?>
                        <!-- <li class="nav-item <?php echo ($menu=='settings')?" active":"";?>">
                        <a class="nav-link" href="?page=bogs&menu=settings">
                            <span class="sidebar-mini"> CS </span>
                            <span class="sidebar-normal"> Course Settings </span>
                        </a>
                        </li>
                        <li class="nav-item <?php echo ($menu=='enter')?" active":"";?>">
                        <a class="nav-link" href="?page=bogs&menu=enter">
                            <span class="sidebar-mini"> EG </span>
                            <span class="sidebar-normal"> Enter Grade </span>
                        </a>
                        </li>
                        <li class="nav-item <?php echo ($menu=='view')?" active":"";?>">
                        <a class="nav-link" href="?page=bogs&menu=view">
                            <span class="sidebar-mini"> VG </span>
                            <span class="sidebar-normal"> View Grade </span>
                        </a>
                        </li> -->
                        <li class="nav-item <?php echo ($menu=='weeklyAssignment')?" active":"";?>">
                        <a class="nav-link" href="?page=bogs&menu=weeklyAssignment">
                            <span class="sidebar-mini"> WA </span>
                            <span class="sidebar-normal"> Weekly Assignment </span>
                        </a>
                        </li>
                        <?php } ?>
                    </ul>
                </div>
            </li>
          <?php } ?>

            <li class="<?php echo ($page=='activities')?" active":"";?>">
                <a href="?page=activities">
                    <i class="material-icons-outlined">accessibility_new</i>
                    <p>School Activities </p>
                </a>
            </li>

            <li class="<?php echo ($page=='selfsubmit')?" active":"";?>">
                <a href="?page=selfsubmit">
                    <i class="material-icons-outlined">description</i>
                    <p> Self-Submitted Activities </p>
                </a>
            </li>
            <?php
              if(in_array($_SESSION['staffRole'], $boardingautharr)){
            ?>
            <li class="<?php echo ($page=='myhall')?" active":"";?>">
                <a href="?page=myhall">
                    <i class="material-icons-outlined">domain</i>
                    <p> My Hall </p>
                </a>
            </li>
            <?php
              }
           ?>

           <?php
             if(in_array($_SESSION['staffRole'], $adminautharr)){
           ?>
            <li class="<?php echo ($page=='currentStudent')?" active":"";?>">
                <a href="?page=currentStudent">
                    <i class="material-icons-outlined">person_pin</i>
                    <p> Current Students </p>
                </a>
            </li>
            <?php
              }
            ?>


            <li class="<?php echo ($page=='searchStudent')?" active":"";?>">
                <a href="?page=searchStudent">
                    <i class="material-icons">search</i>
                    <p> Search Student </p>
                </a>
            </li>

            <li class="<?php echo ($page=='reports')?" active":"";?>">
                <a href="?page=reports">
                    <i class="material-icons">timeline</i>
                    <p> Reports </p>
                </a>
            </li>

            <li class="<?php echo ($page=='career')?" active":"";?>">
                <a href="?page=career">
                    <i class="material-icons">flag</i>
                    <p> Career Life Pathway </p>
                </a>
            </li>

            <!-- <li class="<?php echo ($page=='weeklyAssignment')?" active":"";?>">
                <a href="?page=weeklyAssignment">
                    <i class="material-icons">date_range</i>
                    <p> G8/G9 Weekly Assignment </p>
                </a>
            </li> -->
            <!-- <li class="">
                <a href="?page=vlwe">
                    <i class="material-icons">favorite_border</i>
                    <p> Volunteer & WE Hours </p>
                </a>
            </li> -->

            <!-- <li class="">
              <a href="?page=enrollments">
                  <i class="material-icons">person_add</i>
                  <p> Enrollments </p>
              </a>
          </li> -->

        </ul>

    </div>
</div>
