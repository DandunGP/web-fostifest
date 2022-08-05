@component('mail::message')
<p>Dear {{ $dataMail['nama'] }}</p>

<p>Terimakasih telah mendaftar Capture The Flag (Grow To Be A Cybersecurity Professional).
    Selanjutnya, mohon untuk menyelesaikan tahap-tahap berikut ini sesuai urutan :</p>

<p>1. Login ke akun dengan menggunakan username dan password berikut.</p>
<ul>
    <li>
        <p><span>Username</span>: <span style="font-weight:600">{{ $dataMail['username'] }}</span></p>
    </li>
    <li>
        <p><span>Password</span>: <span style="font-weight:600">{{ $dataMail['password'] }}</span></p>
    </li>
</ul>
<p>2. Mengisi data diri team.</p>
<p>3. Bergabung grup WhatsApp melalui link berikut : https://chat.whatsapp.com/HCyKvgqhXcDJtrAo4jLpEK</p>
<p>Salam,</p>
<p>Fostifest</p>
@endcomponent