@extends('backend.layout.main')
@section('content')
    <div class="container-fluid">
        <div class="row">
            <div class="col-lg-6">
                <h1 class="h3 mb-2 text-gray-800">Daftar Menu</h1>
            </div>
            <div class="col-lg-6 text-right">
                <a href="{{ route('menu.adding') }}" class="btn btn-md btn-primary"><i class="fa fa-plus"></i>
                    Menu Baru
                </a>
            </div>
        </div>

        @if (session()->has('pesan'))
            <div class="alert alert-{{ session()->get('pesan')[0] }}">
                {{ session()->get('pesan')[1] }}
            </div>

        @endif

        <div class="card shadow mb-4">
            <div class="card-body">
                <div class="table-responsive">
                    <table class="table table-bordered table-hover" id="dataTable" width="100%" cellspacing="0">
                        <thead>
                            <tr>
                                <th>No</th>
                                <th>Menu</th>
                                <th>Status</th>
                                <th>Aksi</th>
                            </tr>
                        </thead>

                        <tbody>
                            @php
                                $i = 1;
                            @endphp
                            @foreach ($menu as $k => $row)
                                <tr>
                                    <td>{{ $i++ }}</td>
                                    <td>
                                        {{ $row->menuName }}</br>
                                        <ul>
                                            @foreach ($row->subMenus as $key => $sub)
                                                <li>
                                                    {{ $sub->menuName }}

                                                    <a href="{{ route('menu.modify', $sub->idMenu) }}"><i class="fa fa-edit"
                                                            style="color: #54B4D3">
                                                        </i>
                                                    </a>
                                                    <a href="{{ route('menu.delete', $sub->idMenu) }}"
                                                        onclick="return confirm('Hapus Menu?')"><i class="fa fa-trash"
                                                            style="color: #DC4C64;">
                                                        </i>

                                                    </a>

                                                    <span
                                                        style="color: #DC4C64">{{ $sub->isActive == 1 ? '' : '(Tidak Aktif)' }}</span>
                                                </li>
                                            @endforeach
                                        </ul>
                                    </td>
                                    <td>{{ ($row->isActive == 1) ? "Aktif" : "Tidak Aktif"}}</td>
                                    <td>
                                        <a href="{{ route('menu.modify', $row->idMenu) }}" class="btn btn-sm btn-info"><i
                                                class="fa fa-edit"></i> Edit</a>
                                        <a href="{{ route('menu.delete', $row->idMenu) }}"
                                            onclick="return confirm('Hapus Menu?')" class="btn btn-sm btn-danger"><i
                                                class="fa fa-trash"></i> Hapus</a>

                                        @if ($loop->first)
                                            @php
                                                $nextKey = $k + 1;
                                                $nextId = $menu->get($nextKey)->idMenu;
                                            @endphp
                                            <a href="{{ route('menu.order', [$row->idMenu, $nextId]) }}"
                                                class="btn btn-sm btn-outline-info">
                                                <i class="fa fa-arrow-down"></i>
                                            </a>
                                        @elseif ($loop->last)
                                            @php
                                                $prevKey = $k - 1;
                                                $prevId = $menu->get($prevKey)->idMenu;
                                            @endphp
                                            <a href="{{ route('menu.order', [$row->idMenu, $prevId]) }}"
                                                class="btn btn-sm btn-outline-info">
                                                <i class="fa fa-arrow-up"></i>
                                            </a>
                                        @else
                                            @php
                                                $prevKey = $k - 1;
                                                $prevId = $menu->get($prevKey)->idMenu;
                                                $nextKey = $k + 1;
                                                $nextId = $menu->get($nextKey)->idMenu;
                                            @endphp
                                            <a href="{{ route('menu.order', [$row->idMenu, $prevId]) }}"
                                                class="btn btn-sm btn-outline-info">
                                                <i class="fa fa-arrow-up"></i>
                                            </a>
                                            <a href="{{ route('menu.order', [$row->idMenu, $nextId]) }}"
                                                class="btn btn-sm btn-outline-info">
                                                <i class="fa fa-arrow-down"></i>
                                            </a>
                                        @endif
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
@endsection