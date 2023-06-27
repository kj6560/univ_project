@extends('site.layouts.admin')
@section('content')
<div class="content-wrapper">
    <div class="container-xxl flex-grow-1 container-p-y">
        <div class="col-xl-9">
            <div class="row">
                <!-- HTML5 Inputs -->
                <form action="/dashboard/storeEventGallery" enctype="multipart/form-data" method="POST">
                    @csrf

                    <div class="card mb-4">
                        <h5 class="card-header">Add Images</h5>

                        <div class="card-body">
                            <div class="mb-3 row">
                                <label for="exampleFormControlSelect1" class="form-label">Select Priority</label>
                                <select class="form-select" id="exampleFormControlSelect1" aria-label="Select Priority" name="image_priority">
                                    <option value="0">Select Priority</option>
                                    <option value="1">1</option>
                                    <option value="2">2</option>
                                    <option value="3">3</option>
                                    <option value="4">4</option>
                                    <option value="5">5</option>
                                    <option value="6">6</option>
                                    <option value="7">7</option>
                                    <option value="8">8</option>
                                    <option value="9">9</option>
                                    <option value="10">10</option>
                                    <option value="11">11</option>
                                    <option value="12">12</option>
                                    <option value="13">13</option>
                                    <option value="14">14</option>
                                    <option value="15">15</option>
                                    <option value="16">16</option>
                                    <option value="17">17</option>
                                    <option value="18">18</option>
                                    <option value="19">19</option>
                                    <option value="20">20</option>
                                    <option value="21">21</option>
                                    <option value="22">22</option>
                                    <option value="23">23</option>
                                    <option value="24">24</option>
                                    <option value="25">25</option>
                                </select>
                            </div>

                            <div class="mb-3 row">
                                <label for="exampleFormControlSelect1" class="form-label">Select Event</label>
                                <select class="form-select" id="exampleFormControlSelect1" aria-label="Select Priority" name="event_id">
                                    <option value="0">Select Event</option>
                                    @foreach ($events as $event)
                                    <option value="{{ $event->id }}">{{ $event->event_name }}</option>">1</option>
                                    @endforeach
                                    
                                </select>
                            </div>

                            <div class="mb-3">
                                <label for="formFile" class="form-label">Gallery Image</label>
                                <input type="file" name="image" placeholder="Select Event Main Image" id="inputImage" class="form-control">
                            </div>

                            <div class="mb-3 row">
                                <label for="html5-search-input" class="col-md-2 col-form-label"></label>
                                <div class="col-md-10">
                                    <input class="btn btn-primary" type="submit" value="submit" id="submit" />
                                </div>
                            </div>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
@stop