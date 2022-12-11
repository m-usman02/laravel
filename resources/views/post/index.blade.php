@extends('layouts.master')
@section('css')
<!-- <link href="{{asset('assets/vendor/simple-datatables/style.css')}}" rel="stylesheet"> -->
@endsection
@section('content')
<table class="table" id="post">
                <thead>
                  <tr>
                    <th scope="col">#</th>
                    <th scope="col">Title</th>
                    <th scope="col">Slug</th>
                    <th scope="col">Body</th>
                    <th scope="col">Edit</th>  
                    <th scope="col">Delete</th>               
                  </tr>
                </thead>
                <tbody>
                
              
                </tbody>
              </table>
@endsection
@push('scripts')
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<script>
  // console.log(window.Swal);
    $(document).ready(function(){
      
       posts = $('#post').DataTable({
           processing:true,
           serverSide:true,
           ajax:"{{route('post.index')}}",
           columns:[
               {data:'id',name:'id'},
               {data:'title',name:'title'},
               {data:'slug',name:'slug'},
               {data:'body',name:'body'},
               {data:'edit',name:'edit'},
               {data:'remove',name:'remove'},
           ]
       });
     
       $(document).on('click','.btn-danger',function(e){
          e.preventDefault();
          var id = $(this).data("id");
          Swal.fire({
            title : 'are you sure ? ',
            title: 'Are you sure?',
            showDenyButton: true,           
            confirmButtonText: 'Yes',
          }).then((Delete)=>{
              if(Delete.isConfirmed){
                 $.ajax({
                   url: "/post/"+ id,
                   method: "DELETE",
                   data:{"_token": "{{ csrf_token() }}"},
                   success:function(data){
                      if(data.success){
                        posts.ajax.reload();
                      }
                   }

                 })
              }
          })
       });
    });
</script>
@endpush
