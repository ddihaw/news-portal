@extends('backend.layout.main')
@section('content')
    <div class="container-fluid">
        <h1>Menu Baru</h1>

        <div>
            <div>
                <form action="{{ route('menu.addingProcess') }}" method="post">
                    @csrf
                    <div class="mb-3">
                        <label class="form-label">Nama Menu</label>
                        <input type="text" name="menuName" value="{{ old('menuName') }}"
                            class="form-control @error('menuName') is-invalid @enderror" id="menuName"
                            placeholder="Masukan nama menu">
                        @error('menuName')
                            <span style="color: red; font-weight: 600; font-size: 9pt;">{{$message}}</span>
                        @enderror
                    </div>

                    <div class="mb-3">
                        <label class="form-label">Jenis Menu</label>
                        <div class="radio">
                            <input type="radio" checked value="page" name="menuType" id="page">
                            <label for="page">Page</label>
                            <input type="radio" value="url" name="menuType" id="url">
                            <label for="page">URL</label>
                        </div>
                        @error('menuType')
                            <span style="color: red; font-weight: 600; font-size: 9pt;">{{$message}}</span>
                        @enderror
                    </div>

                    <div class="mb-3">
                        <label class="form-label">URL</label>
                        <div id="showURL">
                            <input type="url" name="menuUrl" value="{{ old('linkURL') }}"
                                class="form-control @error('menuUrl') is-invalid @enderror" id="menuUrl"
                                placeholder="Masukan URL">
                        </div>
                        <div id="showPage">
                            <select name="menuUrl" id="menuUrl" class="form-control @error('menuUrl') is-invalid @enderror">
                                <option value="">Pilih Halaman</option>
                                @foreach ($page as $row)
                                    <option value="{{ $row->idPage }}">{{ $row->pageTitle }}</option>
                                @endforeach
                            </select>
                        </div>
                    </div>

                    <div class="mb-3">
                        <label class="form-label">Target Menu</label>
                        <div class="radio">
                            <input type="radio" checked value="_self" name="menuTarget" id="self">
                            <label for="page">Tab saat ini</label>
                            <input type="radio" value="_blank" name="menuTarget" id="blank">
                            <label for="page">Tab baru</label>
                        </div>
                        @error('menuType')
                            <span style="color: red; font-weight: 600; font-size: 9pt;">{{$message}}</span>
                        @enderror
                    </div>

                    <div class="mb-3">
                        <label class="form-label">Parent Menu</label>
                        <select name="menuParent" id="menuParent"
                            class="form-control @error('menuParent') is-invalid @enderror">
                            <option value="">Pilih Parent Menu</option>
                            @foreach ($parent as $row)
                                <option value="{{ $row->idMenu }}">{{ $row->menuName }}</option>
                            @endforeach
                        </select>
                    </div>

                    <button type="submit" class="btn btn-primary">Tambah</button>
                    <a href="{{ route('menu.index') }}" class="btn btn-secondary">Batal</a>
                </form>
            </div>
        </div>
    </div>

    <script>
        $("#showURL").css("display", "none");

        $("#url").click(function () {
            $("#showURL").css("display", "block");
            $("#showPage").css("display", "none");
        });

        $("#page").click(function () {
            $("#showURL").css("display", "none");
            $("#showPage").css("display", "block");
        });
    </script>
@endsection