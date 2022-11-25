<div>
    <h5 class="mb-4 text-sm 2xl:text-md font-bold">{{ $filter->viewTitle() }}</h5>

    @foreach($filter->viewValues() as $id => $title)
        <div class="form-checkbox">
            <input name="{{ $filter->nameAttribute($id) }}"
                   type="checkbox"
                   value="{{ $id }}"
                   @checked($filter->filterValueFromRequest($id))
                   id="{{ $filter->idAttribute($id) }}"
            >

            <label for="{{ $filter->idAttribute($id) }}" class="form-checkbox-label">
                {{ $title }}
            </label>
        </div>
    @endforeach
</div>
