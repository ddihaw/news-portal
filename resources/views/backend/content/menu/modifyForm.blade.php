@extends('backend.layout.main')

@section('content')
    <div class="container-fluid">
        <h1>Edit Menu</h1>

        <form action="{{ route('menu.modifyProcess') }}" method="post">
            @csrf

            <div class="mb-3">
                <label class="form-label">Nama Menu</label>
                <input type="text" name="menuName" value="{{ $menu->menuName }}"
                    class="form-control @error('menuName') is-invalid @enderror" id="menuName">
                @error('menuName')
                    <span class="text-danger fw-bold" style="font-size: 9pt;">{{ $message }}</span>
                @enderror
            </div>

            <div class="mb-3">
                <label class="form-label">Jenis Menu</label>
                <div class="radio">
                    <input type="radio" value="page" name="menuType" id="page">
                    <label for="page">Page</label>
                    <input type="radio" value="url" name="menuType" id="url">
                    <label for="url">URL</label>
                </div>
                @error('menuType')
                    <span class="text-danger fw-bold" style="font-size: 9pt;">{{ $message }}</span>
                @enderror
            </div>

            <div class="mb-3">
                <label class="form-label">URL / Halaman</label>

                <div id="showURL">
                    <input type="url" name="menuUrl" id="urlInput" value="{{ $menu->menuUrl }}"
                        class="form-control @error('menuUrl') is-invalid @enderror">
                </div>

                <div id="showPage">
                    <select name="menuUrl" id="menuUrlSelect" class="form-control @error('menuUrl') is-invalid @enderror">
                        <option value="">Pilih Halaman</option>
                        @foreach ($page as $row)
                            <option value="{{ $row->idPage }}" {{ $menu->menuUrl == $row->idPage ? 'selected' : '' }}>
                                {{ $row->pageTitle }}
                            </option>
                        @endforeach
                    </select>
                </div>
            </div>

            <div class="mb-3">
                <label class="form-label">Target Menu</label>
                <div class="radio">
                    <input type="radio" value="_self" name="menuTarget" id="self">
                    <label for="self">Tab saat ini</label>
                    <input type="radio" value="_blank" name="menuTarget" id="blank">
                    <label for="blank">Tab baru</label>
                </div>
                @error('menuTarget')
                    <span class="text-danger fw-bold" style="font-size: 9pt;">{{ $message }}</span>
                @enderror
            </div>

            <div class="mb-3">
                <label class="form-label">Parent Menu</label>
                <select name="menuParent" id="menuParent" class="form-control @error('menuParent') is-invalid @enderror">
                    <option value="">Pilih Parent Menu</option>
                    @foreach ($parent as $row)
                        <option value="{{ $row->idMenu }}" {{ $menu->menuParent == $row->idMenu ? 'selected' : '' }}>
                            {{ $row->menuName }}
                        </option>
                    @endforeach
                </select>
            </div>

            <div class="mb-3">
                <label class="form-label">Status</label>
                <select name="isActive" id="isActive" class="form-control">
                    <option value="1" {{ $menu->isActive == 1 ? 'selected' : '' }}>Aktif</option>
                    <option value="0" {{ $menu->isActive == 0 ? 'selected' : '' }}>Tidak Aktif</option>
                </select>
            </div>

            <input type="hidden" name="idMenu" value="{{ $menu->idMenu }}">
            <input type="hidden" id="oldMenuType" value="{{ $menu->menuType }}">
            <input type="hidden" id="oldMenuUrl" value="{{ $menu->menuUrl }}">
            <input type="hidden" id="oldMenuTarget" value="{{ $menu->menuTarget }}">
            <input type="hidden" id="oldMenuParent" value="{{ $menu->menuParent }}">

            <button type="submit" class="btn btn-primary">Simpan Perubahan</button>
            <a href="{{ route('menu.index') }}" class="btn btn-secondary">Batal</a>
        </form>
    </div>

    <script>
        $(function () {
            $("#menuParent").val($("#oldMenuParent").val());
            $("#isActive").val("{{ $menu->isActive }}");

            const oldMenuType = $("#oldMenuType").val();
            const oldMenuUrl = $("#oldMenuUrl").val();

            if (oldMenuType === "page") {
                $("#page").prop("checked", true);
                $("#menuUrlSelect").val(oldMenuUrl);
                $("#showPage").show();
                $("#menuUrlSelect").prop("disabled", false);
                $("#showURL").hide();
                $("#urlInput").prop("disabled", true);
            } else {
                $("#url").prop("checked", true);
                $("#urlInput").val(oldMenuUrl);
                $("#showPage").hide();
                $("#menuUrlSelect").prop("disabled", true);
                $("#showURL").show();
                $("#urlInput").prop("disabled", false);
            }

            const oldTarget = $("#oldMenuTarget").val();
            if (oldTarget === "_self") {
                $("#self").prop("checked", true);
            } else {
                $("#blank").prop("checked", true);
            }

            $("#url").click(function () {
                $("#showURL").show();
                $("#urlInput").prop("disabled", false);
                $("#showPage").hide();
                $("#menuUrlSelect").prop("disabled", true);
            });

            $("#page").click(function () {
                $("#showURL").hide();
                $("#urlInput").prop("disabled", true);
                $("#showPage").show();
                $("#menuUrlSelect").prop("disabled", false);
            });
        });
    </script>
@endsection