<x-layout>

    <div class="container">
        @if (session('success'))
            <div class="alert alert-success">
                {{ session('success') }}
            </div>
        @endif


        <h1>All Users</h1>
        <div>
            <a href="{{ route('users.create') }}" type="button" class="btn btn-primary">Create User</a>
            <!-- Button trigger modal -->

            <table class="table">
                <thead>
                    <tr>
                        <th scope="col">#</th>
                        <th scope="col">Name</th>
                        <th scope="col">Phone</th>
                        <th scope="col">Address</th>
                        <th scope="col">proofs</th>
                        <th scope="col">Action</th>
                    </tr>
                </thead>
                <tbody>
                    @php
                        $i = 1;
                    @endphp
                    @foreach ($users as $user)
                        <tr>
                            <th scope="row">{{ $i++ }}</th>
                            <td>{{ $user->name }}</td>
                            <td>{{ $user->phone }}</td>
                            <td>{{ $user->address }}</td>
                            <td>
                                @isset($user->proofs)
                                    @foreach (json_decode($user->proofs) as $proof)
                                        <a href="{{ Storage::url('public/proof/' . $proof) }}"
                                            target="__blank">Proof{{ $loop->iteration }}</a>
                                    @endforeach
                                @endisset

                            </td>
                            <td class="row">
                                <a href="{{ route('users.edit', $user->id) }}" type="button"
                                    class="btn btn-primary">Edit</a>
                                <form method="post" action="{{ route('users.destroy', $user->id) }}">
                                    @csrf
                                    @method('delete')
                                    <button type="submit" class="btn btn-primary">Delete
                                </form>
                            </td>
                        </tr>
                    @endforeach



                </tbody>
            </table>
        </div>
        <div class="container">

            <h1>All Groups</h1>

            <button type="button" class="btn btn-primary" data-toggle="modal" data-target="#makenewgroup">
                Make New Group
            </button>
        </div>

        <!--Make Group Modal -->
        <div class="modal fade" id="editgroup" tabindex="-1" role="dialog" aria-labelledby="editgroupLabel"
            aria-hidden="true">
            <div class="modal-dialog" role="document">
                <form action="{{ route('group.store') }}" method="post">
                    @csrf
                    <div class="modal-content">
                        <div class="modal-header">
                            <h5 class="modal-title" id="exampleModalLabel">Edit Group</h5>
                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                <span aria-hidden="true">&times;</span>
                            </button>
                        </div>
                        <div class="modal-body">
                            <div class="input-group mb-3">
                                <div class="input-group-prepend">
                                    <span class="input-group-text" id="basic-addon1">Group Name</span>
                                </div>
                                <input type="text" class="form-control" placeholder="name" aria-label="name"
                                    name="name" id="name" aria-describedby="basic-addon1">
                            </div>
                            <h6>Add Users From Below:</h6>
                            @foreach ($users as $item)
                                @if (count($item->groups) < 2)
                                    <div class="form-check">
                                        <input class="form-check-input" type="checkbox" value="{{ $item->id }}"
                                            id="userselect" name="userselect[]">
                                        <label class="form-check-label" for="userselect">
                                            {{ $item->name }}
                                        </label>
                                    </div>
                                @endif
                            @endforeach

                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                            <button type="submit" class="btn btn-primary">Make</button>
                        </div>
                    </div>
                </form>
            </div>
        </div>
        <!--Edit Group Modal -->
        <div class="modal fade" id="makenewgroup" tabindex="-1" role="dialog" aria-labelledby="makenewgroupLabel"
            aria-hidden="true">
            <div class="modal-dialog" role="document">
                <form action="{{ route('group.store') }}" method="post">
                    @csrf
                    <div class="modal-content">
                        <div class="modal-header">
                            <h5 class="modal-title" id="exampleModalLabel">Make New Group</h5>
                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                <span aria-hidden="true">&times;</span>
                            </button>
                        </div>
                        <div class="modal-body">
                            <div class="input-group mb-3">
                                <div class="input-group-prepend">
                                    <span class="input-group-text" id="basic-addon1">Group Name</span>
                                </div>
                                <input type="text" class="form-control" placeholder="name" aria-label="name"
                                    name="name" id="name" aria-describedby="basic-addon1">
                            </div>
                            <h6>Add Users From Below:</h6>
                            @foreach ($users as $item)
                                @if (count($item->groups) < 2)
                                    <div class="form-check">
                                        <input class="form-check-input" type="checkbox" value="{{ $item->id }}"
                                            id="userselect" name="userselect[]">
                                        <label class="form-check-label" for="userselect">
                                            {{ $item->name }}
                                        </label>
                                    </div>
                                @endif
                            @endforeach

                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                            <button type="submit" class="btn btn-primary">Make</button>
                        </div>
                    </div>
                </form>
            </div>
        </div>


        <table class="table">
            <thead>
                <tr>
                    <th scope="col">#</th>
                    <th scope="col">Name</th>
                    <th scope="col">Members</th>
                    <th scope="col">Action</th>
                </tr>
            </thead>
            <tbody>
                @php
                    $i = 1;
                @endphp
                @foreach ($groups as $item)
                    <tr>
                        <th scope="row">{{ $i++ }}</th>
                        <td>{{ $item->name }}</td>
                        <td>{{ count($item->users) }}</td>

                        <td class="row">
                            <a href="{{ route('group.edit', $item->id) }}" type="button"
                                class="btn btn-primary">Edit</a>

                            <form method="post" action="{{ route('group.destroy', $item->id) }}">
                                @csrf
                                @method('delete')
                                <button type="submit" class="btn btn-primary">Delete
                            </form>
                        </td>
                    </tr>
                @endforeach



            </tbody>
        </table>
    </div>
</x-layout>
