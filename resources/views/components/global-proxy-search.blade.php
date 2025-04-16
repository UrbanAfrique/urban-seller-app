<div class="w3-col s12 w3-margin-bottom w3-margin-top">
    <form action="{{$searchRoute}}" class="w3-right w3-d-flex w3-margin-bottom w3-margin-top">
        <input
            name="s"
            value="{{ request()->query('s') }}"
            class="w3-input w3-border  w3-medium w3-border-right-0 w3-input-element"
            type="text" placeholder="Search global..">
        <button type="submit" class="w3-button w3-green w3-medium w3-border-left-0 w3-input-btn">
            <i class="fa fa-search"></i>
        </button>
    </form>
</div>
