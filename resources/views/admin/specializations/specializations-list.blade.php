@foreach ($specializations as $key => $specialization)
<tr id="row_{{ $specialization->id }}" data-position="{{ $specialization->position }}">
    <td>
        @if ($specialization['image'])
            <img src="{{ Storage::url($specialization->image) }}"
                alt="Specialization Image" width="30px" height="30px"
                style="border-radius: 50%">
        @endif
        <span style="margin-left:2px">
            {{ $specialization['name'] }}
        </span>
    </td>
    <td>
        {{ $specialization['slug'] }}
    </td>
    <td>
        <div class="button-switch">
            <input type="checkbox" id="switch-orange" class="switch toggle-class"
                data-id="{{ $specialization['id'] }}"
                {{ $specialization['status'] ? 'checked' : '' }} />
            <label for="switch-orange" class="lbl-off"></label>
            <label for="switch-orange" class="lbl-on"></label>
        </div>
    </td>
    <td>
        <a title="Edit Specialization"
            href="{{ route('specializations.edit', $specialization->id) }}"><i
                class="fas fa-edit"></i></a> &nbsp;&nbsp;
        <a title="Delete Specialization" href="javascript:void(0);" id="delete"
            data-route="{{ route('specializations.delete', $specialization->id) }}"
            class="delete-btn"><i class="fas fa-trash"></i></a>
    </td>
</tr>
@endforeach


