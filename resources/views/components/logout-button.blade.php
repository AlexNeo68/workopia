<form action="{{ route('logout') }}" method="POST">
    @csrf
    @method('DELETE')
    <button type="submit">
        <i class="fa fa-sign-out"></i>
        <span>Logout</span>
    </button>
</form>
