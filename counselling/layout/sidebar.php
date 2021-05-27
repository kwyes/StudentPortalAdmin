<?php
  $page = $_GET['page'];
  $boardingautharr = array(30,31,32);
  $adminautharr = array(10,21,30,31,32,99);

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

            <li class="<?php echo ($page=='weeklyAssignment')?" active":"";?>">
                <a href="?page=weeklyAssignment">
                    <i class="material-icons">date_range</i>
                    <p> G8/G9 Weekly Assignment </p>
                </a>
            </li>
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
