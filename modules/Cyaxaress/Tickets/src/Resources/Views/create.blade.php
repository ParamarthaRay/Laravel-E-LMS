@extends('Dashboard::master')
@section('breadcrumb')
    <li><a href="{{ route('tickets.index') }}" title="Tickets">Tickets</a></li>
    <li><a href="#" title="Create Ticket">Create Ticket</a></li>
@endsection
@section('content')
    <div class="main-content padding-0">
        <p class="box__title">Create New Ticket</p>
        <div class="row no-gutters bg-white">
            <div class="col-12">
                <form action="{{ route("tickets.store") }}" method="post" enctype="multipart/form-data" class="padding-30">
                    @csrf
                    <x-input type="text" class="text" name="title" placeholder="Ticket Title" required />
                    <x-text-area placeholder="Ticket Body" name="body" class="text" required/>
                    <x-file name="attachment" placeholder="Upload Attachment" />
                    <button class="btn btn-webamooz_net">Create Ticket</button>
                </form>
            </div>
        </div>
    </div>
@endsection

@section('js')
    <script src="/panel/js/tagsInput.js?v=12"></script>
@endsection
