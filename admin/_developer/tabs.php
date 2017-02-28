<?php include('../../tilpark.php'); ?>
<?php get_header(); ?>
<?php
add_page_info( 'title', 'Tabs' );
add_page_info( 'nav', array('name'=>'Developer', 'url'=>get_site_url('admin/_developer/') ) );
add_page_info( 'nav', array('name'=>'Tabs') );
?>
<?php include('_header.php'); ?>


<div class="row">
    <div class="col-md-6">

        <div class="panel panel-default">
            <div class="panel-heading"><h3 class="panel-title">Tab menu</h3></div>
            <div class="panel-body _get_example">

<!-- Nav tabs -->
<ul class="nav nav-tabs" role="tablist">
    <li role="presentation" class="active"><a href="#home" aria-controls="home" role="tab" data-toggle="tab">Home</a></li>
    <li role="presentation"><a href="#profile" aria-controls="profile" role="tab" data-toggle="tab">Profile</a></li>
    <li role="presentation"><a href="#messages" aria-controls="messages" role="tab" data-toggle="tab">Messages</a></li>
    <li role="presentation"><a href="#settings" aria-controls="settings" role="tab" data-toggle="tab">Settings</a></li>
</ul>

<!-- Tab panes -->
<div class="tab-content">
    <div role="tabpanel" class="tab-pane fade in active" id="home">Lorem ipsum dolor sit amet, consectetur adipiscing elit. Aliquam porta lacus ipsum, tempus consequat turpis auctor sit amet. Pellentesque porta mollis nisi, pulvinar convallis tellus tristique nec.</div>
    <div role="tabpanel" class="tab-pane fade" id="profile">Consectetur adipisicing elit. Ipsam ut praesentium, voluptate quidem necessitatibus quam nam officia soluta aperiam, recusandae.</div>
    <div role="tabpanel" class="tab-pane fade" id="messages">Nam aliquet consequat quam sit amet dignissim. Quisque vel massa est. Donec dictum nisl dolor, ac malesuada tellus efficitur non. Pellentesque pellentesque odio neque, eget imperdiet eros vehicula lacinia.</div>
    <div role="tabpanel" class="tab-pane fade" id="settings">Delectus, iure sit impedit? Facere provident expedita itaque, magni, quas assumenda numquam eum! Sequi deserunt, rerum.</div>
</div>

            </div> <!-- /.panel-body -->
        </div> <!-- /.panel-default -->

    </div> <!-- /.col-md-6 -->
   <div class="col-md-6">

        <div class="panel panel-default">
            <div class="panel-heading"><h3 class="panel-title">Tab menu with right menu</h3></div>
            <div class="panel-body _get_example">

<!-- Nav tabs -->
<ul class="nav nav-tabs" role="tablist">
    <li role="presentation" class="active"><a href="#home2" aria-controls="home2" role="tab" data-toggle="tab">Home</a></li>
    <li role="presentation"><a href="#profile2" aria-controls="profile2" role="tab" data-toggle="tab">Profile</a></li>
    <li role="presentation"><a href="#messages2" aria-controls="messages2" role="tab" data-toggle="tab">Messages</a></li>
    <li role="presentation" class="pull-right"><a href="#settings2" aria-controls="settings2" role="tab" data-toggle="tab">Right Menu</a></li>
</ul>

<!-- Tab panes -->
<div class="tab-content">
    <div role="tabpanel" class="tab-pane fade in active" id="home2">Lorem ipsum dolor sit amet, consectetur adipiscing elit. Aliquam porta lacus ipsum, tempus consequat turpis auctor sit amet. Pellentesque porta mollis nisi, pulvinar convallis tellus tristique nec.</div>
    <div role="tabpanel" class="tab-pane fade" id="profile2">Consectetur adipisicing elit. Ipsam ut praesentium, voluptate quidem necessitatibus quam nam officia soluta aperiam, recusandae.</div>
    <div role="tabpanel" class="tab-pane fade" id="messages2">Nam aliquet consequat quam sit amet dignissim. Quisque vel massa est. Donec dictum nisl dolor, ac malesuada tellus efficitur non. Pellentesque pellentesque odio neque, eget imperdiet eros vehicula lacinia.</div>
    <div role="tabpanel" class="tab-pane fade" id="settings2">Delectus, iure sit impedit? Facere provident expedita itaque, magni, quas assumenda numquam eum! Sequi deserunt, rerum.</div>
</div>

            </div> <!-- /.panel-body -->
        </div> <!-- /.panel-default -->
        
    </div> <!-- /.col-md-6 -->
</div> <!-- /.row -->




<div class="row">
    <div class="col-md-6">

        <div class="panel panel-default">
            <div class="panel-heading"><h3 class="panel-title">Tab menu width dropdown</h3></div>
            <div class="panel-body _get_example">

<!-- Nav tabs -->
<ul class="nav nav-tabs" role="tablist">
    <li role="presentation" class="active"><a href="#home3" aria-controls="home3" role="tab" data-toggle="tab">Home</a></li>
    <li role="presentation"><a href="#profile3" aria-controls="profile3" role="tab" data-toggle="tab">Profile</a></li>
    <li role="presentation" class="dropdown">
        <a href="#" class="dropdown-toggle" id="myTabDrop1" data-toggle="dropdown" aria-controls="myTabDrop1-contents" aria-expanded="false">Dropdown <span class="caret"></span></a> 
        <ul class="dropdown-menu" aria-labelledby="myTabDrop1" id="myTabDrop1-contents"> 
            <li><a href="#dropdown1" role="tab" id="dropdown1-tab" data-toggle="tab" aria-controls="dropdown1">@fat</a></li> 
            <li><a href="#dropdown2" role="tab" id="dropdown2-tab" data-toggle="tab" aria-controls="dropdown2">@mdo</a></li> 
        </ul>
    </li>
</ul>

<!-- Tab panes -->
<div class="tab-content">
    <div role="tabpanel" class="tab-pane fade in active" id="home3">Lorem ipsum dolor sit amet, consectetur adipiscing elit. Aliquam porta lacus ipsum, tempus consequat turpis auctor sit amet. Pellentesque porta mollis nisi, pulvinar convallis tellus tristique nec.</div>
    <div role="tabpanel" class="tab-pane fade" id="profile3">Consectetur adipisicing elit. Ipsam ut praesentium, voluptate quidem necessitatibus quam nam officia soluta aperiam, recusandae.</div>
    <div role="tabpanel" class="tab-pane fade" id="dropdown1">Nam aliquet consequat quam sit amet dignissim. Quisque vel massa est. Donec dictum nisl dolor, ac malesuada tellus efficitur non. Pellentesque pellentesque odio neque, eget imperdiet eros vehicula lacinia.</div>
    <div role="tabpanel" class="tab-pane fade" id="dropdown2">Delectus, iure sit impedit? Facere provident expedita itaque, magni, quas assumenda numquam eum! Sequi deserunt, rerum.</div>
</div>

            </div> <!-- /.panel-body -->
        </div> <!-- /.panel-default -->

    </div> <!-- /.col-md-6 -->
   <div class="col-md-6">

        <div class="panel panel-default">
            <div class="panel-heading"><h3 class="panel-title">Tab menu width dropdown right</h3></div>
            <div class="panel-body _get_example">

<!-- Nav tabs -->
<ul class="nav nav-tabs" role="tablist">
    <li role="presentation" class="active"><a href="#home4" aria-controls="home4" role="tab" data-toggle="tab">Home</a></li>
    <li role="presentation"><a href="#profile4" aria-controls="profile4" role="tab" data-toggle="tab">Profile</a></li>
    <li role="presentation" class="dropdown pull-right">
        <a href="#" class="dropdown-toggle" id="myTabDrop1" data-toggle="dropdown" aria-controls="myTabDrop1-contents" aria-expanded="false">Dropdown <span class="caret"></span></a> 
        <ul class="dropdown-menu" aria-labelledby="myTabDrop1" id="myTabDrop1-contents"> 
            <li><a href="#dropdown41" role="tab" id="dropdown41-tab" data-toggle="tab" aria-controls="dropdown1">@fat</a></li> 
            <li><a href="#dropdown42" role="tab" id="dropdown42-tab" data-toggle="tab" aria-controls="dropdown2">@mdo</a></li> 
        </ul>
    </li>
</ul>

<!-- Tab panes -->
<div class="tab-content">
    <div role="tabpanel" class="tab-pane fade in active" id="home4">Lorem ipsum dolor sit amet, consectetur adipiscing elit. Aliquam porta lacus ipsum, tempus consequat turpis auctor sit amet. Pellentesque porta mollis nisi, pulvinar convallis tellus tristique nec.</div>
    <div role="tabpanel" class="tab-pane fade" id="profile4">Consectetur adipisicing elit. Ipsam ut praesentium, voluptate quidem necessitatibus quam nam officia soluta aperiam, recusandae.</div>
    <div role="tabpanel" class="tab-pane fade" id="dropdown41">Nam aliquet consequat quam sit amet dignissim. Quisque vel massa est. Donec dictum nisl dolor, ac malesuada tellus efficitur non. Pellentesque pellentesque odio neque, eget imperdiet eros vehicula lacinia.</div>
    <div role="tabpanel" class="tab-pane fade" id="dropdown42">Delectus, iure sit impedit? Facere provident expedita itaque, magni, quas assumenda numquam eum! Sequi deserunt, rerum.</div>
</div>

            </div> <!-- /.panel-body -->
        </div> <!-- /.panel-default -->

    </div> <!-- /.col-md-6 -->
</div> <!-- /.row -->



<style>
.nav-tabs.nav-blank>li.active>a, .nav-tabs.nav-blank>li.active>a:focus, .nav-tabs.nav-blank>li.active>a:hover {
    color: #555;
    cursor: default;
    background-color: transparent;
    border: 1px solid #ddd;
    border-bottom: 2px solid #FFF;
    font-weight: 600;
}
</style>

<div class="row">
    <div class="col-md-6">

        <div class="panel panel-default">
            <div class="panel-heading"><h3 class="panel-title">Tab menu blank style</h3></div>
            <div class="panel-body _get_example">

<!-- Nav tabs -->
<ul class="nav nav-tabs nav-blank" role="tablist">
    <li role="presentation" class="active"><a href="#home5" aria-controls="home5" role="tab" data-toggle="tab">Home</a></li>
    <li role="presentation"><a href="#profile5" aria-controls="profile5" role="tab" data-toggle="tab">Profile</a></li>
    <li role="presentation"><a href="#messages5" aria-controls="messages5" role="tab" data-toggle="tab">Messages</a></li>
    <li role="presentation" class="pull-right"><a href="#settings5" aria-controls="settings5" role="tab" data-toggle="tab">Settings</a></li>
</ul>

<!-- Tab panes -->
<div class="tab-content">
    <div role="tabpanel" class="tab-pane fade in active" id="home5">Lorem ipsum dolor sit amet, consectetur adipiscing elit. Aliquam porta lacus ipsum, tempus consequat turpis auctor sit amet. Pellentesque porta mollis nisi, pulvinar convallis tellus tristique nec.</div>
    <div role="tabpanel" class="tab-pane fade" id="profile5">Consectetur adipisicing elit. Ipsam ut praesentium, voluptate quidem necessitatibus quam nam officia soluta aperiam, recusandae.</div>
    <div role="tabpanel" class="tab-pane fade" id="messages5">Nam aliquet consequat quam sit amet dignissim. Quisque vel massa est. Donec dictum nisl dolor, ac malesuada tellus efficitur non. Pellentesque pellentesque odio neque, eget imperdiet eros vehicula lacinia.</div>
    <div role="tabpanel" class="tab-pane fade" id="settings5">Delectus, iure sit impedit? Facere provident expedita itaque, magni, quas assumenda numquam eum! Sequi deserunt, rerum.</div>
</div>

            </div> <!-- /.panel-body -->
        </div> <!-- /.panel-default -->

    </div> <!-- /.col-md-6 -->
   <div class="col-md-6">

        <div class="panel panel-default">
            <div class="panel-heading"><h3 class="panel-title">Tab menu width icon</h3></div>
            <div class="panel-body _get_example">

<!-- Nav tabs -->
<ul class="nav nav-tabs" role="tablist">
    <li role="presentation" class="active"><a href="#home6" aria-controls="home6" role="tab" data-toggle="tab"><i class="fa fa-globe"></i> Home</a></li>
    <li role="presentation"><a href="#profile6" aria-controls="profile6" role="tab" data-toggle="tab"><i class="fa fa-user"></i> Profile</a></li>
    <li role="presentation"><a href="#messages6" aria-controls="messages6" role="tab" data-toggle="tab"><i class="fa fa-envelope-o"></i> Messages</a></li>
    <li role="presentation" class="pull-right"><a href="#settings6" aria-controls="settings6" role="tab" data-toggle="tab"><i class="fa fa-cog"></i> Settings</a></li>
</ul>

<!-- Tab panes -->
<div class="tab-content">
    <div role="tabpanel" class="tab-pane fade in active" id="home6">Lorem ipsum dolor sit amet, consectetur adipiscing elit. Aliquam porta lacus ipsum, tempus consequat turpis auctor sit amet. Pellentesque porta mollis nisi, pulvinar convallis tellus tristique nec.</div>
    <div role="tabpanel" class="tab-pane fade" id="profile6">Consectetur adipisicing elit. Ipsam ut praesentium, voluptate quidem necessitatibus quam nam officia soluta aperiam, recusandae.</div>
    <div role="tabpanel" class="tab-pane fade" id="messages6">Nam aliquet consequat quam sit amet dignissim. Quisque vel massa est. Donec dictum nisl dolor, ac malesuada tellus efficitur non. Pellentesque pellentesque odio neque, eget imperdiet eros vehicula lacinia.</div>
    <div role="tabpanel" class="tab-pane fade" id="settings6">Delectus, iure sit impedit? Facere provident expedita itaque, magni, quas assumenda numquam eum! Sequi deserunt, rerum.</div>
</div>

            </div> <!-- /.panel-body -->
        </div> <!-- /.panel-default -->

    </div> <!-- /.col-md-6 -->
</div> <!-- /.row -->



<?php get_footer(); ?>