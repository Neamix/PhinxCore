@extends('admin.layouts.app')

@section('content')

@php
$route = explode('.',request()->route()->getName());
$route = array_shift($route) .'.store';
@endphp 

<div class="main-container container-fluid">
    <div class="card mt-4 card-full">
        <div class="card-header w-100 d-flex">
            <h4 class="card-title mb-1">{{ $tour ? 'Update Instance' : 'Add Instance' }}</h4>
        </div>
        <form class="ajax-form" method="post" action="{{ route($route) }}" appendToData="mergeTourRefrences" redirect="{{ route('tour') }}">
            <div class="card-body card-full">

                <div class="row mb-4">
                    <div class="col-sm-12 col-md-4 mg-t-10 mg-sm-t-0">
                        <input type="file" class="dropify" data-default-file="@if($tour->thumbnail) {{ asset('storage/tour/small/'.$tour->thumbnail->name) }} @endif" data-height="200"  name="thumbnail"/>
                    </div>
                    <div class="mx-2 col-md-6">
                        <label for="Tumbnail">Tumbnail</label>
                        <p class="mt-2 sub-text">
                            Enter Beautiful thumbnail to the tour and please add image in aspect ratio to get the best performance
                        </p>
                    </div>
                </div>
                
                <div class="form-group">
                    <label for="title">
                        Title
                    </label>
                    <input class="form-control" type="text" placeholder="Title" id="title" name="title_en" value="@if($tour->title_en) {{ $tour->title_en }} @endif">
                    <input class="form-control mt-2" type="text" placeholder="Title" id="title" name="title_fr" value="@if($tour->title_en) {{ $tour->title_fr }} @endif">
                    <p class="error error_title"></p>
                </div>

                <div class="form-group">
                    <label for="title">
                        Description English
                    </label>
                    <textarea class="summernote" name="description_en">@if($tour->description_en) {{ $tour->description_en }} @endif</textarea>
                    <p class="error error_description_en"></p>
                </div>

                <div class="form-group">
                    <label for="title">
                        Description French
                    </label>
                    <textarea class="summernote" name="description_fr">@if($tour->description_en) {{ $tour->description_fr }} @endif</textarea>
                    <p class="error error_description_fr"></p>
                </div>

                <div class="form-group">
                   
                    <div class="row">
                        <div class="col-md-6">
                            <label for="title">
                                Includes
                            </label>
                            <div class="d-flex align-items-center">
                                <input class="form-control include_form" placeholder="Enter Includes">
                                <i class="fa fa-plus add_prefrence mx-2 d-block" data-container=".include_container" method-append="appendInclude" input=".include_form"></i>
                            </div>
                            <div class="include_container mt-2">
                                @if($tour->tourPrefrences)
                                    @foreach($tour->includes as $include)
                                    <div class="col-md-6 mb-2 d-flex align-items-center section">
                                        <p class="m-0">{{ $include->value }}</p>
                                        <i class="fa fa-minus ms-auto remove_section" data-container=".insert_exclude"></i>
                                        <input type="hidden" value="{{ $include->value }}" name="include[]"> 
                                    </div>
                                    @endforeach
                                @endif
                            </div>
                        </div>
                        <div class="col-md-6 mb-2">
                            <label for="title">
                                Exclude
                            </label>
                            <div class="align-items-center w-100">
                                <div class="d-flex align-items-center w-100">
                                    <input class="form-control exclude_form" placeholder="Enter excludes">
                                    <i class="fa fa-plus add_prefrence mx-2" data-container=".exclude_container" method-append="appendExclude" input=".exclude_form"></i>
                                </div>
                                <div class="exclude_container mt-2">
                                    @if($tour->tourPrefrences)
                                        @foreach($tour->excludes as $exclude)
                                        <div class="col-md-6 mb-2 d-flex align-items-center section">
                                            <p class="m-0">{{ $exclude->value }}</p>
                                            <i class="fa fa-minus ms-auto remove_section" data-container=".insert_exclude"></i>
                                            <input type="hidden" value="{{ $exclude->value }}" name="exclude[]"> 
                                        </div>
                                        @endforeach
                                    @endif
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                

                <div class="form-group"> 
                    <div class="d-flex">
                        <label for="title">
                            Gallary
                        </label>
                        <i class="fa fa-plus mx-2 mt-1 remove_section gallary_btn" data-insert=".insert_gallary"></i>
                    </div>
                    <input type="file" class="insert_gallary gallary_input d-none" data-container=".gallary_container" data-append=".gallary_files">
                    <input type="file" class="gallary_files d-none" name="gallary[]" multiple>
                    @if( ! $tour->gallary->count()) <p class="gallary_empty w-100 text-center">No Image to display here</p> @endif
                    <div class="gallary_container">
                        <div class="row">
                            @if($tour->gallary)
                                
                                @foreach($tour->gallary as $gallary)
                                <div class="col-md-3 gallary_image">
                                    <div class="image_container d-flex justify-content-center w-100 p-2">
                                        <img src="{{ asset('storage/tour/small/'.$gallary->name) }}" alt="badget" model_id="gallary_{{$gallary->id}}" class="gallary_image">
                                        <div class="overlay_image position-absolute w-100 h-100 d-flex justify-content-center align-items-center">
                                            <i class="fas fa-times remove_gallary_btn" data-append="gallary_container" model_id="{{ $gallary->id }}" rel="${file.lastModified}"></i>
                                        </div>
                                    </div>
                                </div>
                                @endforeach

                            @endif
                        </div>
                    </div>
                    <div class="removed_gallary"></div>
                    <p class="error error_gallary"></p>
                </div>

                

                <input value="@if($tour->id) {{ $tour->id }} @endif" type="hidden" name="id">
            </div>
            <div class="card-footer">
                <button class="btn btn-primary">
                    Submit
                </button>
            </div>
        </form>
    </div>
</div>

<script>

    function appendInclude (include) {
        return `
            <div class="col-md-6 mb-2 d-flex align-items-center section">
                <p class="m-0">${include}</p>
                <i class="fa fa-minus ms-auto remove_section" data-container=".insert_exclude"></i>
                <input type="hidden" value="${include}" name="include[]"> 
            </div>
        `
    }

    function appendExclude (exclude) {
        return `
            <div class="col-md-6 mb-2 d-flex align-items-center section">
                <p class="m-0">${exclude}</p>
                <i class="fa fa-minus ms-auto remove_section" data-container=".insert_exclude"></i>
                <input type="hidden" value="${exclude}" name="exclude[]"> 
            </div>
        `
    }

    function storeIncludeInput (e) {
        return `<input type="hidden" name="include[]" class="d-none" value="${e}">`;
    }

    function appendExclude (exclude) {
        return `<div class="col-md-6 mb-2 d-flex align-items-center section">
                    <p class="m-0">${exclude}</p>
                    <i class="fa fa-minus mx-2 remove_section ms-auto remove_section" data-container=".insert_exclude"></i>
                    <input type="hidden" value="${exclude}" name="exclude[]"> 
                </div>`
    }

    function storeExcludeInput (e) {
        return `<input type="hidden" name="exlude[]" class="d-none" value="${e}">`;
    }

    function appendItineraries () {
        return `
        <div class="itinerarires_form section">
            <div class="row">
                <div class="col-md-6">
                    <input type="text" placeholder="Itineraries title english" class="form-control w-100 my-2 title title_en">
                </div>
                <div class="col-md-6">
                    <input type="text" placeholder="Itineraries title frensh" class="form-control w-100 my-2 title title_fr">
                </div>
                <div class="col-md-12">
                    <textarea class="form-control description description_en my-2" placeholder="English Description"></textarea>
                    <textarea class="form-control description description_fr my-2" placeholder="French Description"></textarea>
                </div>
                <div class="col-md-6">
                    <input type="number" class="form-control" placeholder="Day">
                    <i class="fa fa-minus mx-2 remove_section" data-container=".insert_itineraries"></i>
                </div>
            </div>
        </div>
        `
    }

    function mergeTourRefrences () {

        let refrences = [];
        let itinerarires = [];

        $('.itinerarires_form').each( function() {

            let itinerariry = {};

            $(this).find('input,textarea').each(function(){
                if( $(this).hasClass('title') )  {

                    name = $(this).hasClass('title_en') ? 'title_en' : 'title_fr';

                    itinerariry[name]= $(this).val();

                } else if($(this).hasClass('description')) {

                    name = $(this).hasClass('description_en') ? 'description_en' : 'description_fr';

                    itinerariry[name] = $(this).val();

                } else {
                    itinerariry.day = $(this).val();
                }
            });

            itinerarires.push(itinerariry);
            itinerariry = {};

        });

        refrences['itinerarires'] = itinerarires;

        return refrences;

    }

</script>

@endsection