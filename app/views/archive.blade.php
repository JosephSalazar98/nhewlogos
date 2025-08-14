<!doctype html>
<html lang="en">

<head>
    <meta charset="utf-8" />
    <title>Archive — Ideas Vault</title>
    <meta name="viewport" content="width=device-width, initial-scale=1" />

    <style>
        :root {
            --lavender: #00ff73;
            --lavender-2: #00cc5e;
            --bg: #030e05;
            --bg-2: #07160c;
            --text: #f2fff8;
            --muted: #80ffb3;
            --ok: #00fff2;
            --err: #ff00a8;
            --border: rgba(0, 255, 115, .35);
        }

        * {
            box-sizing: border-box;
        }

        html,
        body {
            height: 100%;
        }

        body {
            padding-block: 1rem;
            margin: 0;
            background:
                radial-gradient(1200px 600px at 70% -10%, rgba(0, 255, 115, .06), transparent 60%),
                linear-gradient(180deg, var(--bg) 0%, #020a04 100%);
            color: var(--text);
            font: 14px/1.45 ui-monospace, SFMono-Regular, Menlo, Monaco, Consolas, "Liberation Mono", monospace;
            letter-spacing: .15px;
        }

        .wrap {
            max-width: 130rem;
            margin-inline: auto;
            padding: 0 16px;
        }

        .panel-box {
            background: linear-gradient(180deg, var(--bg) 0%, var(--bg-2) 100%);
            border: 1px solid var(--border);
            border-radius: 10px;
            box-shadow: 0 0 0 1px rgba(0, 255, 115, .18) inset, 0 30px 60px rgba(0, 255, 115, .06);
            overflow: hidden;
            position: relative;
        }

        .panel-box::after {
            content: "";
            position: absolute;
            inset: 0;
            background-image: repeating-linear-gradient(to bottom,
                    rgba(0, 255, 115, .035), rgba(0, 255, 115, .035) 1px,
                    transparent 1px, transparent 3px);
            pointer-events: none;
            mix-blend-mode: lighten;
        }

        .titlebar {
            display: flex;
            align-items: center;
            gap: 10px;
            padding: 10px 14px;
            background: linear-gradient(180deg, rgba(0, 255, 115, .10), rgba(0, 255, 115, .04));
            border-bottom: 1px solid var(--border);
            color: var(--muted);
            font-size: 13px;
        }

        .dot {
            width: 8px;
            height: 8px;
            border-radius: 50%;
            background: var(--lavender-2);
            opacity: .9;
        }

        .titlebar .title {
            color: var(--muted);
        }

        .content {
            padding: 14px;
        }

        .table-wrap {
            border: 1px solid var(--border);
            border-radius: 8px;
            background: #08120a;
            padding: 8px;
        }

        table.vault {
            width: 100%;
            border-collapse: collapse;
            font-size: 13px;
        }

        table.vault thead th {
            color: var(--muted);
            text-align: left;
            padding: 8px;
            border-bottom: 1px solid var(--border);
        }

        table.vault tbody td {
            padding: 8px;
            border-bottom: 1px dashed rgba(0, 255, 115, .18);
        }

        table.vault tbody tr:hover {
            background: rgba(0, 255, 115, .04);
        }

        .cell-actions {
            display: flex;
            gap: 8px;
            align-items: center;
        }

        a.link {
            text-decoration: none;
            padding: 4px 8px;
            border-radius: 6px;
            border: 1px solid var(--border);
            background: #06140c;
            transition: filter .15s ease, transform .02s ease;
        }

        a.view {
            color: var(--ok);
        }

        a.dl {
            color: var(--lavender);
        }

        a.link:hover {
            filter: brightness(1.15);
            transform: translateY(-1px);
        }

        .empty {
            color: var(--muted);
            text-align: center;
            padding: 20px 8px !important;
        }

        /* Responsive */
        @media (max-width: 640px) {
            .table-wrap {
                padding: 6px;
            }

            table.vault,
            thead,
            tbody,
            th,
            td,
            tr {
                display: block;
                width: 100%;
            }

            thead {
                display: none;
            }

            tr {
                margin-bottom: 10px;
                background: #06140c;
                border: 1px solid var(--border);
                border-radius: 6px;
            }

            td {
                border: none;
                padding: 6px 8px;
            }

            td::before {
                content: attr(data-label);
                display: block;
                color: var(--muted);
                font-size: 12px;
                margin-bottom: 2px;
            }

            .cell-actions {
                justify-content: flex-start;
            }
        }
    </style>
</head>

<body>
    <div class="wrap">
        <div
            style="border-radius: 10px; display:flex; justify-content:space-between; align-items:center; border:1px solid var(--border); background:var(--bg-2); padding:4px 10px; font-family:monospace; font-size:13px; letter-spacing:0.5px; color:var(--text);">

            <!-- Left -->
            <a href="https://x.com/Eserya77" target="_blank"
                style="color:var(--lavender); text-decoration:none; padding:0 6px; border-right:1px solid var(--border);">
                X_PROFILE
            </a>

            <!-- Center -->
            <a href="/"
                style="color:var(--ok); text-decoration:none; padding:0 6px; border-right:1px solid var(--border);">
                CONSOLE
            </a>

            <!-- Right -->
            <span id="contract-address" onclick="copyContract()"
                style="cursor:pointer; padding:0 6px; color:var(--err);">
                CONTRACT: 0x1234...abcd
            </span>

        </div>

        <script>
            function copyContract() {
                const contract = "0x1234567890abcdef1234567890abcdef12345678";
                navigator.clipboard.writeText(contract).then(() => {
                    const el = document.getElementById("contract-address");
                    const original = el.textContent;
                    el.textContent = "[COPIED]";
                    setTimeout(() => {
                        el.textContent = original;
                    }, 1500);
                });
            }
        </script>
        <pre class="ascii" aria-hidden="true" style="font-size: 0.25rem">

                                                          
     ##### /                                              
  ######  /                                               
 /#   /  /                                                
/    /  /                                                 
    /  /                                                  
   ## ##              /###     /###      /###     /###    
   ## ##             / ###  / /  ###  / / ###  / / #### / 
   ## ##            /   ###/ /    ###/ /   ###/ ##  ###/  
   ## ##           ##    ## ##     ## ##    ## ####       
   ## ##           ##    ## ##     ## ##    ##   ###      
   #  ##           ##    ## ##     ## ##    ##     ###    
      /            ##    ## ##     ## ##    ##       ###  
  /##/           / ##    ## ##     ## ##    ##  /###  ##  
 /  ############/   ######   ########  ######  / #### /   
/     #########      ####      ### ###  ####      ###/    
#                                   ###                   
 ##                           ####   ###                  
                            /######  /#                   
                           /     ###/                     

</pre>
        <section class="panel-box" role="region" aria-label="Archive">
            <div class="titlebar">
                <div class="dot" aria-hidden="true"></div>
                <div class="dot" aria-hidden="true"></div>
                <div class="dot" aria-hidden="true"></div>
                <div class="title">Archive — Ideas Vault
                    <span style="opacity:.7;">({{ count($files) }} files)</span>
                </div>
            </div>

            <div class="content">
                <div class="table-wrap">
                    <table class="vault" aria-label="Ideas files">
                        <thead>
                            <tr>
                                <th>File</th>
                                <th>Size</th>
                                <th>Modified</th>
                                <th>Actions</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse ($files as $f)
                                <tr>
                                    <td data-label="File">{{ $f['name'] }}</td>
                                    <td data-label="Size">{{ $f['size_h'] }}</td>
                                    <td data-label="Modified">{{ $f['modified_h'] }}</td>
                                    <td data-label="Actions">
                                        <div class="cell-actions">
                                            <a class="link view" href="{{ $f['url'] }}" target="_blank">[VIEW]</a>
                                            <a class="link dl" href="{{ $f['url'] }}" download>[DOWNLOAD]</a>
                                        </div>
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td class="empty" colspan="4">No files found in <code>/public/ideas</code>.</td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>
        </section>

    </div>
</body>

</html>
