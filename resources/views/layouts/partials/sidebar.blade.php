 <!-- ======= Sidebar ======= -->
 <aside id="sidebar" class="sidebar">

<ul class="sidebar-nav" id="sidebar-nav">

  <li class="nav-item">
    <a class="nav-link " href="index.html">
      <i class="bi bi-grid"></i>
      <span>Dashboard</span>
    </a>
  </li><!-- End Dashboard Nav -->

 


  <li class="nav-item">
        <a class="nav-link collapsed" data-bs-target="#components-nav" data-bs-toggle="collapse" href="#">
          <i class="bi bi-menu-button-wide"></i><span>Post</span><i class="bi bi-chevron-down ms-auto"></i>
        </a>
        <ul id="components-nav" class="nav-content collapse " data-bs-parent="#sidebar-nav">
          <li>
            <a href="{{route('post.index')}}">
              <i class="bi bi-circle"></i><span>Post List</span>
            </a>
          </li>
          <li>
            <a href="{{route('post.create')}}">
              <i class="bi bi-circle"></i><span>Create Post</span>
            </a>
          </li>
         
        
        </ul>
      </li><!-- End Register Page Nav -->






</ul>

</aside><!-- End Sidebar-->