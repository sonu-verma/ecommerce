<ul class="account-nav">
    <li><a href={{ route('user.index') }} class="menu-link menu-link_us-s">Dashboard</a></li>
    <li><a href="{{ route('user.orders') }}" class="menu-link menu-link_us-s">Orders</a></li>
    <li><a href="account-address.html" class="menu-link menu-link_us-s">Addresses</a></li>
    <li><a href="account-details.html" class="menu-link menu-link_us-s">Account Details</a></li>
    <li><a href="account-wishlist.html" class="menu-link menu-link_us-s">Wishlist</a></li>
    <li>
        <form action="{{ route('logout')}}" method="POST" id="sidebar_logout_link">
            @csrf
            <a href="#" onclick="event.preventDefault();document.getElementById('sidebar_logout_link').submit()" class="menu-link menu-link_us-s">Logout</a>
        </form>
    </li>
</ul>