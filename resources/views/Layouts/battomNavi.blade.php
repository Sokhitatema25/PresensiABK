 <!-- App Bottom Menu -->
 <div class="appBottomMenu">
        <a href="/dashboard" class="item {{request()->is('dashboard') ? 'active': ''}}">
            <div class="col">
            <ion-icon name="home-sharp"></ion-icon>
                <strong>Home</strong>
            </div>
        </a>
      
        <a href="/Absensi/history" class="item {{request()->is('Absensi/history') ? 'active': ''}}">
            <div class="col">
                <ion-icon name="time-sharp" role="img" class="md hydrated"
                aria-label="document text outline"></ion-icon>
                <strong>Histori</strong>
            </div>
        </a>
        <a href="/Absensi/create" class="item">
            <div class="col">
                <div class="action-button large">
                    <ion-icon name="camera" role="img" class="md hydrated" aria-label="add outline"></ion-icon>
                </div>
            </div>
        </a>
        <a href="/Absensi/izin" class="item  {{request()->is('Absensi/izin') ? 'active': ''}}">
            <div class="col">
               
                <ion-icon name="hand-left-sharp" role="img" class="md hydrated"
                    aria-label="document text outline"></ion-icon>
                <strong>Izin</strong>
            </div>
        </a>
        <a href="/editprofile" class="item {{request()->is('editprofile') ? 'active': ''}}">
            <div class="col">
                <ion-icon name="person-sharp" role="img" class="md hydrated" aria-label="people outline"></ion-icon>
                <strong>Profile</strong>
            </div>
        </a>
    </div>
    <!-- * App Bottom Menu -->
  