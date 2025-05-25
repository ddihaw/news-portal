@extends('frontend.layout.main')
@section('content')
    <section class="py-5">
        <div class="container px-5 my-5">
            <div class="row gx-5">
                <div class="col-lg-12">
                    <!-- Post content-->
                    <article>
                        <!-- Post header-->
                        <header class="mb-4">
                            <!-- Post title-->
                            <h1 class="fw-bolder mb-1">{{ $page->pageTitle }}</h1>
                            <!-- Post meta content-->
                            <div class="text-muted fst-italic mb-2">
                                {{ \Carbon\Carbon::parse($page->created_at)->translatedFormat('d F Y') }}
                                &middot;
                            </div>
                        </header>
                        <!-- Post content-->
                        <section class="mb-5">
                            <p class="fs-5 mb-4">{!! $page->pageContent !!}</p>
                        </section>
                    </article>
                </div>
            </div>
        </div>
    </section>
@endsection