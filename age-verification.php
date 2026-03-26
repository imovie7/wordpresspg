<?php
/**
 * Plugin Name: SecretGarden Age Verification
 * Description: 18+ 年龄验证弹窗 / 18+ Age Verification Modal
 * Version: 1.0.0
 */

if ( ! defined( 'ABSPATH' ) ) exit;

add_action( 'wp_footer', 'sg_age_verification_modal' );
function sg_age_verification_modal() {
    if ( is_admin() ) return;
    ?>
    <style>
    #sg-age-overlay {
        position: fixed;
        inset: 0;
        z-index: 99999;
        background: rgba(0,0,0,0.97);
        display: flex;
        align-items: center;
        justify-content: center;
        backdrop-filter: blur(8px);
        font-family: Georgia, 'Times New Roman', serif;
    }
    #sg-age-overlay.sg-hidden {
        display: none;
    }
    #sg-age-box {
        background: #12121a;
        border: 1px solid #2a2a3d;
        border-radius: 12px;
        padding: 3em 3.5em;
        max-width: 480px;
        width: 92%;
        text-align: center;
        box-shadow: 0 0 80px rgba(123,63,160,0.25), 0 0 30px rgba(201,168,76,0.1);
        animation: sg-fade-in 0.4s ease;
    }
    @keyframes sg-fade-in {
        from { opacity: 0; transform: translateY(20px); }
        to   { opacity: 1; transform: translateY(0); }
    }
    #sg-age-box .sg-logo {
        font-size: 1.8em;
        font-weight: bold;
        letter-spacing: 0.18em;
        text-transform: uppercase;
        background: linear-gradient(135deg, #7b3fa0, #c9a84c);
        -webkit-background-clip: text;
        -webkit-text-fill-color: transparent;
        background-clip: text;
        margin-bottom: 0.3em;
    }
    #sg-age-box .sg-tagline {
        color: #888899;
        font-size: 0.85em;
        letter-spacing: 0.08em;
        margin-bottom: 2em;
        font-style: italic;
    }
    #sg-age-box .sg-badge {
        width: 72px;
        height: 72px;
        border-radius: 50%;
        background: linear-gradient(135deg, #7b3fa0, #c9a84c);
        margin: 0 auto 1.5em;
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: 1.8em;
        font-weight: bold;
        color: #fff;
        letter-spacing: -0.02em;
    }
    #sg-age-box h2 {
        color: #e8e8f0;
        font-size: 1.3em;
        letter-spacing: 0.06em;
        margin-bottom: 0.5em;
    }
    #sg-age-box p {
        color: #888899;
        font-size: 0.9em;
        line-height: 1.7;
        margin-bottom: 2em;
    }
    #sg-age-box .sg-lang {
        color: #555566;
        font-size: 0.8em;
        margin-bottom: 1.5em;
        font-style: italic;
    }
    .sg-btn-group {
        display: flex;
        gap: 1em;
        justify-content: center;
        flex-wrap: wrap;
    }
    .sg-btn-enter {
        background: linear-gradient(135deg, #7b3fa0, #c9a84c);
        color: #fff;
        border: none;
        border-radius: 6px;
        padding: 0.85em 2.5em;
        font-size: 0.95em;
        letter-spacing: 0.1em;
        text-transform: uppercase;
        cursor: pointer;
        transition: opacity 0.2s, transform 0.2s;
        font-family: Georgia, serif;
    }
    .sg-btn-enter:hover {
        opacity: 0.85;
        transform: translateY(-2px);
    }
    .sg-btn-leave {
        background: transparent;
        color: #555566;
        border: 1px solid #2a2a3d;
        border-radius: 6px;
        padding: 0.85em 2em;
        font-size: 0.95em;
        letter-spacing: 0.08em;
        text-transform: uppercase;
        cursor: pointer;
        transition: color 0.2s, border-color 0.2s;
        font-family: Georgia, serif;
    }
    .sg-btn-leave:hover {
        color: #e8e8f0;
        border-color: #555566;
    }
    #sg-age-box .sg-disclaimer {
        color: #333344;
        font-size: 0.75em;
        margin-top: 1.8em;
        line-height: 1.5;
    }
    </style>

    <div id="sg-age-overlay">
        <div id="sg-age-box">
            <div class="sg-logo">SecretGarden</div>
            <div class="sg-tagline">Premium Adult Lifestyle · 高端成人生活方式</div>
            <div class="sg-badge">18+</div>
            <h2>Adults Only / 仅限成年人</h2>
            <p>This website contains adult content intended for individuals 18 years of age or older.</p>
            <div class="sg-lang">本网站包含成人内容，仅供18岁及以上人士浏览。</div>
            <p style="margin-bottom:0.5em; font-size:0.85em;">By entering, you confirm that you are at least 18 years old and agree to our terms of service.</p>
            <div class="sg-btn-group">
                <button class="sg-btn-enter" id="sg-confirm-age">
                    I Am 18+ · 我已满18岁
                </button>
                <button class="sg-btn-leave" id="sg-deny-age">
                    Exit · 离开
                </button>
            </div>
            <div class="sg-disclaimer">
                By clicking "I Am 18+", you confirm you are of legal age to view adult content in your jurisdiction.<br>
                点击进入即表示您确认在您所在地区已达到法定年龄。
            </div>
        </div>
    </div>

    <script>
    (function() {
        var overlay = document.getElementById('sg-age-overlay');
        var confirmed = localStorage.getItem('sg_age_confirmed');
        var expiry = localStorage.getItem('sg_age_expiry');
        var now = Date.now();

        if (confirmed === '1' && expiry && parseInt(expiry) > now) {
            overlay.classList.add('sg-hidden');
            return;
        }

        document.getElementById('sg-confirm-age').addEventListener('click', function() {
            var exp = now + (24 * 60 * 60 * 1000); // 24 hours
            localStorage.setItem('sg_age_confirmed', '1');
            localStorage.setItem('sg_age_expiry', exp.toString());
            overlay.classList.add('sg-hidden');
        });

        document.getElementById('sg-deny-age').addEventListener('click', function() {
            window.location.href = 'https://www.google.com';
        });
    })();
    </script>
    <?php
}
