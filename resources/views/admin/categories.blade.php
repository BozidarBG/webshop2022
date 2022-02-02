@extends('layouts.admin')
@section('styles')
    <style>

    </style>
@endsection

@section('content')
{{--    @include('partials.succes_msg')--}}
    @include('partials.confirmation_modal')
<div id="fc_toaster" class="position-absolute w-25 alert d-none" style="z-index: 10"></div>
    <div class="col-md-8 col-sm-12">
        <!-- Table -->
        <div class="card card-warning">
            <div class="card-header ">
                <h3 class="card-title">Categories</h3>
            </div>
            <!-- /.card-header -->
            <div class="card-body table-responsive p-0">
                <table class="table table-hover text-nowrap">
                    <thead>
                    <tr>
                        <th>ID</th>
                        <th>Name</th>
                        <th>Products</th>
                        <th>Edit</th>
                        <th>Delete</th>
                    </tr>
                    </thead>
                    <tbody id="table_body">
                    @forelse($categories as $category)
                    <tr>
                        <td>{{$category->id}}</td>
                        <td id="{{$category->id}}_name">{{$category->name}}</td>
                        <td>{{$category->product_count}}</td>
                        <td><button class="fc_edit btn btn-warning" data-id="{{$category->id}}" data-name="{{$category->name}}" data-route="{{route('admin.categories.update', ['id'=>$category->id])}}">Edit</button></td>
                        <td><button class="fc_delete_modal btn btn-danger" data-toggle="modal" data-target="#confirmation_modal" data-route="{{route('admin.categories.destroy', ['id'=>$category->id])}}">Delete</button></td>
                    </tr>
                    @empty
                        <tr><td>There are no categories</td></tr>
                    @endforelse
                    </tbody>
                </table>
            </div>
            <!-- /.card-body -->
        </div>
        <!-- end table -->
    </div>
    <div class="col-md-4 col-sm-12">
        <div class="card card-info" id="create_div">
            <div class="card-header">
                <h3 class="card-title">Add new category</h3>
            </div>
            <!-- /.card-header -->
            <!-- form start -->
            <form class="form-horizontal" action="{{route('admin.categories.store')}}" method="POST" id="create_form">
                @csrf
                <div class="card-body">
                    <div class="col-md-12 form-group ">
                        <input type="text" class="fc form-control" name="name" placeholder="Name" onfocus="this.placeholder = ''" onblur="this.placeholder = 'Name'" required>
                    </div>

                </div>
                <!-- /.card-body -->
                <div class="card-footer">
                    <button type="submit" class="btn btn-info" id="create_btn">Create</button>
                </div>
                <!-- /.card-footer -->
            </form>
        </div>

        <div class="card card-info d-none" id="edit_div">
            <div class="card-header">
                <h3 class="card-title">Edit category</h3>
            </div>
            <!-- /.card-header -->
            <!-- form start -->
            <form class="form-horizontal" action="" method="POST" id="edit_form">
                @csrf
                <div class="card-body">
                    <div class="col-md-12 form-group ">
                        <input type="text" class="fc form-control" name="name" id="name_update" placeholder="Name" onfocus="this.placeholder = ''" onblur="this.placeholder = 'Name'" required>
                    </div>

                </div>
                <!-- /.card-body -->
                <div class="card-footer">
                    <button type="submit" class="btn btn-warning" id="update_btn">Update</button>
                </div>
                <!-- /.card-footer -->
            </form>
        </div>
    </div>
@endsection
@section('scripts')
<!--
<script>
    const rules={
        name:{required:true, minLength:2, maxLength:50},
    }
    let confirmation_modal=document.getElementById('confirmation_modal');

    const editRow=(e)=>{
        //show edit form div, hide create form div
        document.getElementById('create_div').classList.add('d-none');
        document.getElementById('edit_div').classList.remove('d-none');

        let ev_target=e.target;
        const updateRow=(data)=>{
            //console.log(data);
            if(data.data.errors){
                //console.log(data.data.errors)
                //refresh page
                location.reload();
            }else{
                //change data sets in e.target
                ev_target.setAttribute('data-name', data.data.success.name);
                //change data in table
                document.getElementById(data.data.success.id+"_name").textContent=data.data.success.name;
                addToaster('alert-success', 'Category updated successfully!');
                //show create form div, hide edit form div
                document.getElementById('create_div').classList.remove('d-none');
                document.getElementById('edit_div').classList.add('d-none');
                resetForms();
            }
        }
        //show form and fill with data

        let edit_div=document.getElementById('edit_div');
        edit_div.classList.remove('d-none');
        let edit_form=document.getElementById('edit_form');
        let old_name_input=document.getElementById('name_update');
        old_name_input.value=e.target.getAttribute('data-name');
        edit_form.setAttribute('action', "/admin/categories/update/"+e.target.getAttribute('data-id'));

        //let update_form=document.getElementById('update_form');
        edit_form.addEventListener('submit', (e)=>{
            e.preventDefault();

            let formCheck=new FormSubmition('edit_form', rules, 'ajax', updateRow);
            if(formCheck.hasErrors()){
                formCheck.putErrorsAboveEveryInput(formCheck.errorsObj, ['alert', 'alert-danger'], 'p');
            }else{
                formCheck.sendPostViaAjax();
                //edit_div.classList.add('d-none');
                //edit_form.submit();
                //location.reload();
            }
        });

    }

    const createRecord=(e)=>{
        e.target.setAttribute('disabled', true);
        setTimeout(()=>{
            e.target.removeAttribute('disabled')
        },1000);
        const addNewRowToTable=(d)=>{
            console.log(d.data.errors)
            if(d.data.errors){
                addToaster('alert-danger', d.data.errors);
                return;
            }
            if(d.data.success){
                let data=d.data.success;
                let row=`
            <tr>
                <td>${data.id}</td>
                <td id="${data.id}_name">${data.name}</td>
                <td>0</td>
                <td><button class="fc_edit btn btn-warning" data-id="${data.id}" data-name="${data.name}" >Edit</button></td>
                <td><button class="fc_delete_modal btn btn-danger" data-toggle="modal" data-target="#confirmation_modal" data-route="/admin/categories/delete/+${data.id}">Delete</button></td>
            </tr>
            `;

                document.getElementById('table_body').innerHTML +=row;
                addToaster('alert-success', 'Category created successfully');
                resetForms();
                addListeners();
            }

        }
        let form_obj=new FormSubmition('create_form', rules, 'http', addNewRowToTable);
        if(form_obj.hasErrors()){
            form_obj.putErrorsAboveEveryInput();
        }else{
            //send via form.submti();
            //document.getElementById('create_form').submit();
            //send via ajax
            //console.log(form_obj)
            //return
            form_obj.sendPostViaAjax();

        }
    }

    const resetForms =()=>{
        let forms=document.getElementsByTagName('form');
        for(let i=0; i<forms.length; i++){
            forms[i].reset();
        }
    }


    const clearErrorMessages=(id)=>{
        let errorDiv=document.getElementById(id);
        errorDiv.innerHTML="";

    }

    //delete with modal
    //kad se klikne delete, aktivira se bootstrap modal
    //kad se klikne na id="confirmation_modal_confirm" šalje se delete sa ajax.
    //može kontroler da uradi return redirect()->route('neka ruta); ako je ok ili da vrati return response json(['error
    //ili da vrati return response()->json(['success']) pa da dalje js briše red
    // ili greške (npr ne postoji ili ne može da se briše)

    const getDeleteRowAndRoute=(e)=>{
        let deleteRoute =e.target.hasAttribute('data-route') ? e.target.getAttribute('data-route') : null;
        let rowToBeDeleted=e.target.closest('tr');
        //console.log(deleteRoute, rowToBeDeleted);

        const deleteRow=(e)=>{
            axios.post(deleteRoute, {}).then((data)=>{
                //console.log(data)
                if(data.data.hasOwnProperty('success')){
                    $('#confirmation_modal').modal('hide');//too complicated to use without jQ
                    rowToBeDeleted.remove();
                    addToaster('alert-success', 'Row deleted successfully')
                }else if(data.data.hasOwnProperty('errors')){
                    $('#confirmation_modal').modal('hide');//too complicated to use without jQ
                    addToaster('alert-danger', data.data.errors)
                }
            });
        }
        new Listener('click', 'confirm_modal_button', 'id', deleteRow);
    }

    const addToaster=(className="alert-success", msg)=>{
        const timer=(clasName)=>{
            toaster.classList.contains('alert-danger') ? toaster.classList.remove('alert-danger') :null;
            toaster.classList.contains('alert-success') ? toaster.classList.remove('alert-success') :null;
            toaster.textContent="";
            toaster.classList.add('d-none');
        };
        let toaster=document.getElementById('fc_toaster');
        toaster.textContent=msg;
        toaster.classList.add(className);
        toaster.classList.remove('d-none');
        setTimeout(timer, 2000);
    }
    const disableClick=(e)=>{
        e.target.setAttribute('disabled', true);
        setTimeout(()=>{
            console.log(e.target)
            e.target.removeAttribute('disabled')
        },1000);
    }

    const addListeners=()=>{
        //new Listener('click', 'create_btn','id', disableClick);
        new Listener('submit', 'create_form','id', createRecord);
        new Listener('click', 'fc_edit','class', editRow);
        new Listener('click', 'fc_delete_modal', 'class', getDeleteRowAndRoute);//delete listener
    }


    addListeners();

</script>
-->
<script>
    const rules={
        name:{required:true, minLength:2, maxLength:50},
    }
    let confirmation_modal=document.getElementById('confirmation_modal');

    const newTableRow=(data)=>{
        return `
            <tr>
                <td>${data.id}</td>
                <td id="${data.id}_name">${data.name}</td>
                <td>0</td>
                <td><button class="fc_edit btn btn-warning" data-id="${data.id}" data-name="${data.name}" data-route="/admin/categories/update/+${data.id}">Edit</button></td>
                <td><button class="fc_delete_modal btn btn-danger" data-toggle="modal" data-target="#confirmation_modal" data-route="/admin/categories/delete/+${data.id}">Delete</button></td>
            </tr>
            `;
    }

    const editRow=(e)=>{
        //show edit form div, hide create form div
        document.getElementById('create_div').classList.add('d-none');
        document.getElementById('edit_div').classList.remove('d-none');

        let ev_target=e.target;
        const updateHtml=(data)=>{
            //console.log(data);
            if(data.data.errors){
                //console.log(data.data.errors)
                //refresh page
                location.reload();
            }else{
                //change data sets in e.target
                ev_target.setAttribute('data-name', data.data.success.name);
                //change data in table
                document.getElementById(data.data.success.id+"_name").textContent=data.data.success.name;
                addToaster('alert-success', 'Category updated successfully!');
                //show create form div, hide edit form div
                document.getElementById('create_div').classList.remove('d-none');
                document.getElementById('edit_div').classList.add('d-none');
                resetForms();
            }
        }
        //show form and fill with data

        let edit_div=document.getElementById('edit_div');
        edit_div.classList.remove('d-none');
        let edit_form=document.getElementById('edit_form');
        let old_name_input=document.getElementById('name_update');
        let updateRoute=e.target.getAttribute('data-route')
        old_name_input.value=e.target.getAttribute('data-name');
        edit_form.setAttribute('action', updateRoute);

        //let update_form=document.getElementById('update_form');
        edit_form.addEventListener('submit', (e)=>{
            e.preventDefault();

            let formCheck=new FormSubmition('edit_form', rules, 'ajax', updateHtml);
            if(formCheck.hasErrors()){
                formCheck.putErrorsAboveEveryInput(formCheck.errorsObj, ['alert', 'alert-danger'], 'p');
            }else{
                formCheck.sendPostViaAjax();
                //edit_div.classList.add('d-none');
                //edit_form.submit();
                //location.reload();
            }
        });

    }

    const createRecord=(e, newTableRow)=>{
        e.target.setAttribute('disabled', true);
        setTimeout(()=>{
            e.target.removeAttribute('disabled')
        },1000);
        const addNewRowToHtml=(d)=>{
            //console.log(d.data.errors)
            if(d.data.errors){
                addToaster('alert-danger', d.data.errors);
                return;
            }
            if(d.data.success){
                let data=d.data.success;
                document.getElementById('table_body').innerHTML +=newTableRow(data.data.success);
                addToaster('alert-success', 'Category created successfully');
                resetForms();
                addListeners();
            }

        }
        let form_obj=new FormSubmition('create_form', rules, 'http', addNewRowToHtml);
        if(form_obj.hasErrors()){
            form_obj.putErrorsAboveEveryInput();
        }else{
            //send via form.submti();
            //document.getElementById('create_form').submit();
            //send via ajax
            //console.log(form_obj)
            //return
            form_obj.sendPostViaAjax();

        }
    }

    const resetForms =()=>{
        let forms=document.getElementsByTagName('form');
        for(let i=0; i<forms.length; i++){
            forms[i].reset();
        }
    }


    const clearErrorMessages=(id)=>{
        let errorDiv=document.getElementById(id);
        errorDiv.innerHTML="";

    }

    //delete with modal
    //kad se klikne delete, aktivira se bootstrap modal
    //kad se klikne na id="confirmation_modal_confirm" šalje se delete sa ajax.
    //može kontroler da uradi return redirect()->route('neka ruta); ako je ok ili da vrati return response json(['error
    //ili da vrati return response()->json(['success']) pa da dalje js briše red
    // ili greške (npr ne postoji ili ne može da se briše)

    const deleteRow=(e)=>{
        let deleteRoute =e.target.hasAttribute('data-route') ? e.target.getAttribute('data-route') : null;
        let rowToBeDeleted=e.target.closest('tr');
        //console.log(deleteRoute, rowToBeDeleted);

        const removeRowFromHtml=(e)=>{
            axios.post(deleteRoute, {}).then((data)=>{
                //console.log(data)
                $('#confirmation_modal').modal('hide');//too complicated to use without jQ
                if(data.data.hasOwnProperty('success')){
                    rowToBeDeleted.remove();
                    addToaster('alert-success', 'Row deleted successfully')
                }else if(data.data.hasOwnProperty('errors')){
                    addToaster('alert-danger', data.data.errors)
                }
            });
        }
        new Listener('click', 'confirm_modal_button', 'id', removeRowFromHtml);
    }

    const addToaster=(className="alert-success", msg)=>{
        const timer=(clasName)=>{
            toaster.classList.contains('alert-danger') ? toaster.classList.remove('alert-danger') :null;
            toaster.classList.contains('alert-success') ? toaster.classList.remove('alert-success') :null;
            toaster.textContent="";
            toaster.classList.add('d-none');
        };
        let toaster=document.getElementById('fc_toaster');
        toaster.textContent=msg;
        toaster.classList.add(className);
        toaster.classList.remove('d-none');
        setTimeout(timer, 2000);
    }
    const disableClick=(e)=>{
        e.target.setAttribute('disabled', true);
        setTimeout(()=>{
            console.log(e.target)
            e.target.removeAttribute('disabled')
        },1000);
    }

    const addListeners=()=>{
        //new Listener('click', 'create_btn','id', disableClick);
        new Listener('submit', 'create_form','id', createRecord);
        new Listener('click', 'fc_edit','class', editRow);
        new Listener('click', 'fc_delete_modal', 'class', deleteRow);//delete listener
    }


    addListeners();

</script>
@endsection

