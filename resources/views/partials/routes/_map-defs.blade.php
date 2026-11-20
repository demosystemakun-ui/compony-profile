<!-- {{-- ═══ SVG DEFINITIONS: Gradients, Ship Icon, Flag Symbols ═══ --}}
<defs>
    <linearGradient id="earthSeaGrad" x1="0" y1="0" x2="900" y2="460" gradientUnits="userSpaceOnUse">
        <stop offset="0%" stop-color="#e0f2fe" />
        <stop offset="100%" stop-color="#bae6fd" />
    </linearGradient>

    <radialGradient id="patimbanGlow" cx="50%" cy="50%" r="50%">
        <stop offset="0%" stop-color="#ef4444" stop-opacity="0.9" />
        <stop offset="100%" stop-color="#ef4444" stop-opacity="0" />
    </radialGradient>

    {{-- Ship icon used by all route markers --}}
    <g id="shipIcon">
        <path d="M-8 -3.5 L4 -3.5 L9 0 L4 3.5 L-8 3.5 Z" fill="currentColor" />
        <rect x="-4" y="-2" width="5" height="4" rx="0.8" fill="#ffffff" />
        <rect x="-6" y="-1.2" width="1.5" height="2.4" fill="#0f172a" />
    </g>

    {{-- ═══ FLAG SYMBOLS ═══ --}}
    <clipPath id="flagClip"><rect width="20" height="14" rx="2" /></clipPath>

    <g id="flag-id">
        <rect width="20" height="14" rx="2" fill="#ffffff" stroke="#cbd5e1" stroke-width="0.5" />
        <rect width="20" height="7" fill="#ec2029" rx="2" />
        <rect width="20" height="2" y="5" fill="#ec2029" />
    </g>

    <g id="flag-jp">
        <rect width="20" height="14" rx="2" fill="#ffffff" stroke="#cbd5e1" stroke-width="0.5" />
        <circle cx="10" cy="7" r="4" fill="#ec2029" />
    </g>

    <g id="flag-cn">
        <rect width="20" height="14" rx="2" fill="#ec2029" stroke="#cbd5e1" stroke-width="0.5" />
        <polygon points="4,2 5,4 3,3 5,3 3,4" fill="#facc15" />
    </g>

    <g id="flag-th">
        <rect width="20" height="14" rx="2" fill="#ffffff" stroke="#cbd5e1" stroke-width="0.5" />
        <rect width="20" height="2.3" y="0" fill="#ec2029" />
        <rect width="20" height="2.3" y="11.7" fill="#ec2029" />
        <rect width="20" height="4.6" y="4.7" fill="#26347a" />
    </g>

    <g id="flag-ph">
        <rect width="20" height="14" rx="2" fill="#ffffff" stroke="#cbd5e1" stroke-width="0.5" />
        <rect width="20" height="7" fill="#1d4ed8" />
        <rect width="20" height="7" y="7" fill="#ec2029" />
        <polygon points="0,0 10,7 0,14" fill="#ffffff" />
        <circle cx="3.5" cy="7" r="1.5" fill="#facc15" />
    </g>

    <g id="flag-my">
        <rect width="22" height="14" fill="#CC0000" rx="1"/>
        <rect width="22" height="2" y="2" fill="#FFFFFF"/>
        <rect width="22" height="2" y="6" fill="#FFFFFF"/>
        <rect width="22" height="2" y="10" fill="#FFFFFF"/>
        <rect width="11" height="8" fill="#003366"/>
    </g>

    <g id="flag-sg">
        <rect width="22" height="14" fill="#EE1C25" rx="1"/>
        <rect width="22" height="7" y="7" fill="#FFFFFF"/>
        <circle cx="5" cy="3.5" r="2" fill="#FFFFFF"/>
        <circle cx="5.8" cy="3.5" r="1.6" fill="#EE1C25"/>
    </g>

    <g id="flag-bn">
        <rect width="22" height="14" fill="#ffcc00" rx="1"/>
        <path d="M0,0 L22,4.6 L22,9.4 L0,14 Z" fill="#ffffff"/>
        <path d="M0,4.6 L22,7 L22,14 L0,9.4 Z" fill="#000000"/>
        <g transform="translate(11,7) scale(0.35)">
            <path d="M-4,-8 L4,-8 L2,6 L-2,6 Z" fill="#cc0000"/>
            <circle cx="0" cy="-9" r="2" fill="#cc0000"/>
            <path d="M-6,2 C-6,-2 6,-2 6,2 C6,5 -6,5 -6,2 Z" fill="#cc0000"/>
        </g>
    </g>
</defs> -->