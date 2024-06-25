<x-layout>
    <div class="container">
        <h1>Edit Group</h1>

        <form action="{{ route('group.update', $group->id) }}" method="post">
            @csrf
            @method('put')
            <div class="">

                <div class="">
                    <div class="form-group">
                      
                        <label for="group">Group Name</label>
                        
                        <input type="text" class="form-control @error('name') is-invalid @enderror" placeholder="name" aria-label="name" name="name"
                            id="name" value="{{ $group->name }}" aria-describedby="basic-addon1">
                        @error('name')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                    <h6>Add Users From Below:</h6>
                    @foreach ($users as $user)
                        @if ($group->users->contains($user->id))
                            <div class="form-check">
                                <input class="form-check-input"
                                    {{ $group->users->contains($user->id) ? 'checked' : '' }} type="checkbox"
                                    value="{{ $user->id }}" id="userselect" name="userselect[]">
                                <label class="form-check-label" for="userselect">
                                    {{ $user->name }}
                                </label>
                            </div>
                        @else
                            @if (count($user->groups) < 2)
                                <div class="form-check">
                                    <input class="form-check-input" type="checkbox" value="{{ $user->id }}"
                                        id="userselect" name="userselect[]">
                                    <label class="form-check-label" for="userselect">
                                        {{ $user->name }}
                                    </label>
                                </div>
                            @else
                                <div class="form-check">
                                    <input class="form-check-input" type="checkbox" value="{{ $user->id }}" disabled
                                        id="userselect" name="userselect[]">
                                    <label class="form-check-label" for="userselect">
                                        {{ $user->name }} (Already Present in 2 groups)
                                    </label>
                                </div>
                            @endif
                        @endif
                    @endforeach

                </div>
                <div class="modal-footer">
                    <a type="button" href="{{ route('users.index') }}" class="btn btn-secondary">Back</a>
                    <button type="submit" class="btn btn-primary">Save</button>
                </div>
            </div>
        </form>

</x-layout>
