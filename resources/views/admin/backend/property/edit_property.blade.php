@extends('admin.admin_dashboard')
@section('admin') 
 

<style>
    .form-group label{
        color: #000;
        font-weight: 500;
    }

    /* Gallery image style code  */
    .image-preview {
        position: relative;
        display: inline-block;
    }

    .image-preview img {
        width: 150px;
        height: 100px;
        object-fit: cover;
        border: 1px solid #ddd;
        border-radius: 6px;
    }

    .remove-image {
        position: absolute;
        top: -8px;
        right: -8px;
        background-color: #ff4d4d;
        color: white;
        border: none;
        border-radius: 50%;
        width: 22px;
        height: 22px;
        cursor: pointer;
        font-size: 14px;
        display: flex;
        align-items: center;
        justify-content: center;
    }
</style>

<section role="main" class=""> 
   <header class="page-header">
    <h2>Edit Property</h2> 
    <div class="right-wrapper text-end">
        <ol class="breadcrumbs">
            <li>
                <a href="index.html">
                    <i class="bx bx-home-alt"></i>
                </a>
            </li> 
            <li><span>Edit Property</span></li>  
        </ol>  
    </div>
</header>

    <form action="{{ route('update.property',$editData->id) }}" method="POST" enctype="multipart/form-data">
        @csrf

        <!-- Tabs -->
        <ul class="nav nav-tabs" role="tablist">
            <li class="nav-item"><a class="nav-link active" data-bs-toggle="tab" href="#property" role="tab">Property Settings</a></li>
            <li class="nav-item"><a class="nav-link" data-bs-toggle="tab" href="#investment" role="tab">Investment Settings</a></li>
           
        </ul>

<div class="tab-content pt-3">

    <!-- Property Settings -->
    <div class="tab-pane fade show active" id="property" role="tabpanel">
        <div class="form-group text-center">
            <div class="position-relative d-inline-block shadow rounded" style="width: 400px; height: 200px; overflow: hidden;">
                <!-- Image Preview -->
                <img id="showImage" src="{{ asset($editData->image) }}" class="img-fluid w-100 h-100 object-fit-cover" alt="Preview">

                <!-- Upload Button -->
                <label for="image" class="position-absolute bottom-0 end-0 m-2 bg-primary p-2 rounded-circle text-white" style="cursor:pointer;">
                    <i class="fas fa-upload"></i>
                </label>

                <!-- File Input -->
                <input type="file" name="image" id="image" class="d-none" accept="image/*">
            </div>

            <p class="mt-2 text-muted">
                <span class="text-danger">Property Image.</span>
                Supported Files: <strong>.png, .jpg, .jpeg</strong>. Image will be resized into <strong>555x370px</strong>
            </p>
            
            @error('image')
                <span class="text-danger">{{ $message }}</span>
            @enderror

        </div>

        <!-- Title -->
        <div class="form-group my-4">
            <label class="fw-bold">Title <span class="text-danger">*</span></label>
            <input type="text" name="title" id="titleInput" class="form-control" value="{{ $editData->title }}"> 
        </div>

        <!-- Slug -->
        <div class="form-group position-relative">
            <label class="fw-bold">Slug <span class="text-danger">*</span></label>
            <div class="d-flex align-items-center">
                <input type="text" name="slug" id="slugInput" class="form-control me-2" value="{{ $editData->slug }}">
                <a href="javascript:void(0);" onclick="generateSlug()" class="text-primary text-decoration-none">
                        <i class="fas fa-link"></i> Make Slug
                </a>
            </div> 
        </div>

        <div class="row mt-2">
    <div class="col-md-6">
        <div class="form-group">
        <label>Location  <span class="text-danger">*</span></label>
        <select name="location_id" id="location" class="form-control">
            <option value="">Select Location</option>
            @foreach ($location as $item)
                <option value="{{ $item->id }}" {{ $editData->location_id == $item->id ? 'selected' : '' }} >{{ $item->name }}</option>
            @endforeach
        </select>
        </div>
        @error('location_id')
            <span class="text-danger">{{ $message }}</span>
        @enderror
</div>

            <div class="col-md-6">
                <div class="form-group">
                <label>Location Map URL <span class="text-danger">*</span></label>
                <input type="text" name="location_map" class="form-control" value="{{ $editData->location_map }}">
                </div>
            </div>
        </div>

        <!-- Gallery Image Upload -->
        <div class="form-group mt-2">
            <label class="fw-bold">Gallery Images <span class="text-danger">(You can add multiple images)</span></label>

        <div class="border border-dashed text-center p-5 rounded" id="preview_img" style="cursor: pointer">
            <div id="preview_img">
                @foreach ($multiimg as $img)
   <div class="image-wrapper d-inline-block m-2" id="img-{{ $img->id }}">
    <img src="{{ asset($img->image) }}" style="width: 150px" height="100px; object-fit:cover;">
    <a href="javascript:void(0)" class="remove-icon" data-id="{{ $img->id }}">
        <i class="fa fa-times"></i>
    </a> 
            </div> 
                @endforeach 
            </div>  

       <i class="fas fa-cloud-upload-alt fa-2x text-muted"></i>
       <p class="mt-2 text-muted">Click to browse multiple images</p> 
        </div> 
  <small class="text-muted d-block mt-2">Supported Files: <strong>.png, .jpg, .jpeg</strong>. Image will be resized into <strong>840x450px</strong></small>

 <input type="file" name="gallery_images[]" id="multiImg" class="d-none" accept="image/*" multiple>
</div>
 
            

            <!-- Details -->
            <div class="form-group mt-4">
            <label class="fw-bold">Details</label>
            <textarea name="details" id="detailsEditor" class="form-control" rows="8">{{ $editData->details }}</textarea>
            </div>


        <div class="form-group">
            <label>Is Featured</label>
            <select name="is_featured" class="form-control">
                <option value="no" {{ $editData->is_featured == 'no' ? 'selected' : ''  }} >No</option>
                <option value="yes" {{ $editData->is_featured == 'yes' ? 'selected' : ''  }}>Yes</option>
            </select>
        </div>

        <div class="form-group">
            <label>Status</label>
            <select name="status" class="form-control">
                <option value="1" {{ $editData->status == '1' ? 'selected' : ''  }}>Enabled</option>
                <option value="0" {{ $editData->status == '0' ? 'selected' : ''  }}>Disabled</option>
            </select>
        </div> 
        
    </div>

    <!-- Investment Settings -->
    <div class="tab-pane fade" id="investment" role="tabpanel">
        <div class="row mt-2">

<div class="col-md-6">
    <div class="form-group">
        <label>Investment Type <span class="text-danger">*</span></label>
        <select name="investment_type" id="investment_type" class="form-control">
            <option value="">Select One</option>
            <option value="One-Time-Investment" {{ $editData->investment_type == 'One-Time-Investment' ? 'selected' : ''  }}>One Time Investment </option>
            <option value="Investment-By-Installment" {{ $editData->investment_type == 'Investment-By-Installment' ? 'selected' : ''  }}>Investment By Installment</option>
        </select>
    </div>
</div>

            <div class="col-md-6">
                <div class="form-group">
                    <label>Total Share <span class="text-danger">*</span></label>
                    <input type="number" name="total_share" class="form-control"  value="{{ $editData->total_share }}">
                </div>
            </div>
        </div>
        <div class="row mt-2">
            <div class="col-md-6">
                <div class="form-group">
                    <label>Per Share Amount <span class="text-danger">*</span></label>
                    <div class="input-group">
                        <input type="number" step="0.01" name="per_share_amount" class="form-control" value="{{ $editData->per_share_amount }}">
                        <span class="input-group-text" id="basic-addon2">USD</span>
                    </div>
                </div>
            </div>
            <div class="col-md-6">
                <div class="form-group">
                    <label>Capital Back <span class="text-danger">*</span></label>
                    <select name="capital_back" id="capital_back" class="form-control">
                        <option value="">Select One</option>
                        <option value="Yes" {{ $editData->capital_back == 'Yes' ? 'selected' : ''  }}>Yes </option>
                        <option value="No" {{ $editData->capital_back == 'No' ? 'selected' : ''  }}>No</option>
                    </select>
                </div>
            </div>
        </div>
        <div class="row mt-2">
            <div class="col-md-6">
                <div class="form-group">
                    <label>Main Capital Back <span class="text-danger">*</span></label>
                    <div class="input-group">
                        <input type="number" name="profit_back" id="profitBackInput" class="form-control" value="{{ $editData->profit_back }}" >
                        <span class="input-group-text">Day</span>
                    </div>
                </div>
            </div>
            <div class="col-md-6" id="profitAmountTypeSelect">
                <div class="form-group">
                    <label>Profit Type <span class="text-danger">*</span></label>
                    <select name="profit_type" class="form-control">
                        <option value="">Select One</option>
                        <option value="fixed" {{ $editData->profit_type == 'fixed' ? 'selected' : ''  }}>Fixed</option>
                        <option value="range" {{ $editData->profit_type == 'range' ? 'selected' : ''  }}>Range</option>
                    </select>
                </div>
            </div>
        </div>

        <!-- need to condition here for hide & show -->
        <div id="installmentFields">
            <div class="row mt-4">
                <div class="col-md-4">
                    <div class="form-group">
                        <label>Total Installment</label>
                        <input type="number" name="total_installment" class="form-control" value="{{ $editData->total_installment }}">
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="form-group">
                        <label>Down Payment</label>
                        <div class="input-group">
                            <input type="number" step="0.01" name="down_payment" class="form-control" value="{{ $editData->down_payment }}">
                            <span class="input-group-text">%</span>
                        </div>
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="form-group">
                        <label>Per Installment Amount</label>
                        <div class="input-group">
                            <input type="number" step="0.01" name="per_installment_amount" class="form-control" readonly value="{{ $editData->per_installment_amount }}">
                            <span class="input-group-text">USD</span>
                        </div>
                    </div>
                </div>
            </div>
            <div class="row mt-2">
                <div class="col-md-6">
                    <div class="form-group">
                        <label>Installment Late Fee</label>
                            <div class="input-group">
                            <input type="number" step="0.01" name="installment_late_fee" class="form-control" value="{{ $editData->installment_late_fee }}">
                            <span class="input-group-text">%</span>
                        </div>
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="form-group">
                        <label>Time Between Installment</label>
                        <input type="text" name="time_between_installment" class="form-control" value="{{ $editData->time_between_installment }}">
                    </div>
                </div>
            </div>
        </div>


        <div class="row mt-4">
            <div class="col-md-6">
                <div class="form-group">
                    <label>Profit Amount Type</label>
                    <select name="profit_amount_type" id="profit_amount_type" class="form-control">
                        <option value="">Select One</option>
                        <option value="%" {{ $editData->profit_amount_type == '%' ? 'selected' : ''  }}>% </option>
                        <option value="USD" {{ $editData->profit_amount_type == 'USD' ? 'selected' : ''  }}>USD</option>
                    </select>
                </div>
            </div>
            <div class="col-md-6" id="minimumProfit">
                <div class="form-group">
                    <label>Minimum Profit Amount</label>
                    <div class="input-group">
                        <input type="number" step="0.01" name="minimum_profit_amount" id="minimum_profit_amount" class="form-control"  value="{{ $editData->minimum_profit_amount }}">
                        <span class="input-group-text" id="basic-addon2">%</span>
                    </div>
                </div>
            </div>
            <div class="col-md-6" id="fixedProfit">
                <div class="form-group">
                    <label>Profit Amount</label>
                    <div class="input-group">
                        <input type="number" step="0.01" name="profit_amount" id="profit_amount" class="form-control"  value="{{ $editData->profit_amount }}">
                        <span class="input-group-text" id="basic-addon2">%</span>
                    </div>
                </div>
            </div>
        </div>

        <div class="row mt-2">
            <div class="col-md-6" id="profit_distribution_wrapper">
                <div class="form-group">
                    <label>Profit Distribution <span class="text-danger">*</span></label>
                    <select name="profit_distribution" id="profit_distribution" class="form-control">
                        <option value="">Select One</option>
                        <option value="Manual" {{ $editData->profit_distribution == 'Manual' ? 'selected' : ''  }}>Manual</option>
                        <option value="Auto" {{ $editData->profit_distribution == 'Auto' ? 'selected' : ''  }}>Auto</option>
                    </select>
                </div>
            </div>
            <div class="col-md-6" id="auto_profit_wrapper">
                <div class="form-group">
                    <label>Auto Profit Distribution (%)</label>
                    <div class="input-group">
                        <input type="number" step="0.01" name="auto_profit_distribution" id="auto_profit_distribution" class="form-control" value="{{ $editData->auto_profit_distribution }}">
                        <span class="input-group-text">%</span>
                    </div>
                </div>
            </div>
        </div>


        <div class="row mt-4">
<div class="col-md-6" id="profitScheduleWrapper">
    <div class="form-group">
        <label>Profit Schedule <span class="text-danger">*</span></label>
        <select name="profit_schedule" id="profit_schedule" class="form-control">
            <option value="">Select One</option>
            <option value="One-Time" {{ $editData->profit_schedule == 'One-Time' ? 'selected' : ''  }}>One Time</option>
            <option value="Life-Time" {{ $editData->profit_schedule == 'Life-Time' ? 'selected' : ''  }}>Life Time</option>
            <option value="Repeated-Time" {{ $editData->profit_schedule == 'Repeated-Time' ? 'selected' : ''  }}>Repeated Time</option>
        </select>
    </div>
</div>
            <div class="col-md-6" id="profitSchedulePeriodWrapper">
                <div class="form-group">
                    <label>Profit Schedule Period</label>
                    <select name="time_id" id="profit_schedule_period" class="form-control">
                        <option value="">Select One</option>
                        @foreach ($times as $item)
                            <option value="{{ $item->id }}" {{ $editData->time_id == $item->id ? 'selected' : ''  }}>{{ $item->time_name }}</option>
                        @endforeach
                    </select>
                </div>
            </div>
        </div>
        <div class="form-group mt-2" id="repeatTimeWrapper">
            <div class="col-md-12">
                <label>Repeat Time</label>
                <input type="number" name="repeat_time" id="repeat_time" class="form-control" value="{{ $editData->repeat_time }}">
            </div>
        </div>


        <input type="hidden" name="submitted_tab" value="investment">
        
    </div>  

</div>

        <!-- Final Full Submit -->
        <div class="text-center mt-4">
           <button type="submit" class="btn btn-success mt-3">Save Property Settings</button>
        </div>

    </form>
</section>


<!--------===Show MultiImage ========------->
<!-- jQuery -->
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>

<!-- Script -->
<script>
$(document).ready(function () {
    // Only this triggers the input
    $('#preview_img').on('click', function () {
        $('#multiImg').trigger('click');
    });

    $('#multiImg').on('change', function () {
        const files = this.files;
        $('#preview_img').empty(); // Clear previous previews

        if (files.length === 0) {
            $('#preview_img').html('<p class="text-muted">No files selected.</p>');
        }

        $.each(files, function (i, file) {
            if (/\.(jpe?g|png|gif|webp)$/i.test(file.name)) {
                const reader = new FileReader();
                reader.onload = function (e) {
                    const img = $('<img/>').addClass('thumb').attr('src', e.target.result).css({
                        width: '100px',
                        height: '80px',
                        margin: '5px',
                        border: '1px solid #ccc',
                        'object-fit': 'cover'
                    });
                    $('#preview_img').append(img);
                };
                reader.readAsDataURL(file);
            }
        });
    });
});
</script>

<script>
     document.addEventListener('DOMContentLoaded', function() {

    const investmentType = document.getElementById('investment_type');
	const installmentFields = document.getElementById('installmentFields');

    function toggleInstallmentFields(){
        if (investmentType.value === 'Investment-By-Installment') {
			installmentFields.style.display = 'block';
		}else {
			installmentFields.style.display = 'none';
		}
    }

    toggleInstallmentFields();

    investmentType.addEventListener('change',toggleInstallmentFields);

     });

</script>
 
 <script>
    document.addEventListener('DOMContentLoaded', function(){
        const capitalBackSelete = document.getElementById('capital_back');
        const profitBackInput = document.getElementById('profitBackInput');

        function updateProfitBackState(){
            if (capitalBackSelete.value === 'No') {
                profitBackInput.disabled = true;
                profitBackInput.value = '';
            }else {
                profitBackInput.disabled = false;
            }
        }

        // Initial state will be setup
        updateProfitBackState();
        capitalBackSelete.addEventListener('change',updateProfitBackState);

    });
 </script>
 

<script>
    document.addEventListener('DOMContentLoaded', function(){
        const profitTypeSelete = document.querySelector('select[name="profit_type"]');
        const minimumProfitDiv = document.getElementById('minimumProfit');
        const fixedProfitDiv = document.getElementById('fixedProfit');

    function toggleProfitFields(){
        const selectedValue = profitTypeSelete.value;

        minimumProfitDiv.classList.add('col-md-6');
        fixedProfitDiv.classList.add('col-md-6');

        if (selectedValue === 'Fixed') {
            fixedProfitDiv.style.display = 'block';
            minimumProfitDiv.style.display = 'none';
        } else if (selectedValue === 'Range'){
            fixedProfitDiv.style.display = 'none';
            minimumProfitDiv.style.display = 'block';
        } else {
            fixedProfitDiv.style.display = 'block';
            minimumProfitDiv.style.display = 'none';
        }
    }

    // Initialize state
    toggleProfitFields();

    profitTypeSelete.addEventListener('change',toggleProfitFields);

    });

</script>

{{-- /// Delete multiple Image by Ajax --}}
<script>
    document.addEventListener('DOMContentLoaded', function(){
        document.querySelectorAll('.remove-icon').forEach(function(btn) {
            btn.addEventListener('click', function(){
                let id = this.getAttribute('data-id');
                if(!confirm("Are you sure to delete this image?")) return;
        
       fetch("{{ url('property/galleryimage-delete') }}/" + id, {
            method: 'DELETE',
            headers: {
                'X-CSRF-TOKEN': '{{ csrf_token() }}',
                'Accept': 'application/json',
            },
        })
        .then(res => res.json())
        .then(data => {
            if (data.success) {
                document.getElementById('img-'+ id).remove();
            }else{
                alert(data.message || 'Delete failed');
            }
        });

            });
        });
    });

</script>

 


@endsection