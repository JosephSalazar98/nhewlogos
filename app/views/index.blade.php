<!doctype html>
<html lang="en">

<head>
    <meta charset="utf-8" />
    <title>Idea Terminal</title>
    <meta name="viewport" content="width=device-width, initial-scale=1" />
    <!-- Alpine.js -->
    <script defer src="https://unpkg.com/alpinejs@3.x.x/dist/cdn.min.js"></script>
    <!-- D3.js v7 -->
    <script src="https://d3js.org/d3.v7.min.js"></script>

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
            padding: 0;
            margin: 0;
        }

        html {
            padding: 1rem;

        }

        html,
        body {
            height: 100%;
        }

        body {
            align-content: center;
            margin: 0;
            background:
                radial-gradient(1200px 600px at 70% -10%, rgba(196, 181, 253, .08), transparent 60%),
                linear-gradient(180deg, #0b0b10 0%, #0a0a11 100%);
            color: var(--text);
            font: 14px/1.45 ui-monospace, SFMono-Regular, Menlo, Monaco, Consolas, "Liberation Mono", "Courier New", monospace;
            letter-spacing: .15px;
        }

        .wrap {
            max-width: 130rem;
            margin-inline: auto;
            padding-inline: 1rem;
            overflow-x: auto;
        }

        /* NEW: two-column layout, right panel spans both rows */
        .columns {
            display: grid;
            grid-template-columns: minmax(420px, 1fr) minmax(520px, 1.4fr);
            grid-template-rows: auto auto;
            /* left stack: two rows */
            gap: 18px;
            align-items: stretch;
            min-width: 980px;
        }

        /* Right panel spans both rows to match the mock */
        .span-rows-2 {
            grid-row: 1 / span 2;
        }

        @media screen and (max-width: 1024px) {
            .columns {
                display: flex;
                flex-direction: column;
                gap: 1rem;
                min-width: initial;
            }

            .span-rows-2 {
                grid-row: auto;
            }
        }

        /* Console panels (keep your look) */
        .terminal,
        .monitor,
        .viz {
            background: linear-gradient(180deg, var(--bg) 0%, var(--bg-2) 100%);
            border: 1px solid var(--border);
            border-radius: 10px;
            box-shadow: 0 0 0 1px rgba(164, 150, 255, .15) inset, 0 30px 60px rgba(164, 150, 255, .08);
            overflow: hidden;
            position: relative;
        }

        .terminal::after,
        .monitor::after,
        .viz::after {
            content: "";
            position: absolute;
            inset: 0;
            background-image: repeating-linear-gradient(to bottom,
                    rgba(196, 181, 253, .035), rgba(196, 181, 253, .035) 1px,
                    transparent 1px, transparent 3px);
            pointer-events: none;
            mix-blend-mode: lighten;
        }

        .titlebar {
            display: flex;
            align-items: center;
            gap: 10px;
            padding: 10px 14px;
            background: linear-gradient(180deg, rgba(196, 181, 253, .10), rgba(196, 181, 253, .04));
            border-bottom: 1px solid var(--border);
        }

        .dot {
            width: 10px;
            height: 10px;
            border-radius: 50%;
            background: var(--lavender);
            opacity: .75
        }

        .title {
            margin-left: 8px;
            color: var(--muted);
            font-size: 13px;
        }

        .panel {
            padding: 18px 18px 20px;
        }

        .ascii {
            color: var(--lavender);
            opacity: .95;
            margin: 6px 0 16px 0;
            white-space: pre;
            font-size: 12px;
            line-height: 1.05;
            text-shadow: 0 0 6px rgba(196, 181, 253, .35);
        }

        .help {
            color: var(--muted);
            margin-bottom: 12px;
        }

        .grid {
            display: flex;
            flex-direction: column;
            gap: 12px;
        }

        label {
            display: block;
            margin-bottom: 6px;
            color: var(--muted);
            font-size: 12px;
        }

        input[type="text"],
        textarea {
            width: 100%;
            color: var(--text);
            background: #0e0e15;
            border: 1px solid var(--border);
            border-radius: 8px;
            padding: 10px 12px;
            outline: none;
            transition: border-color .18s ease;
        }

        textarea {
            min-height: 120px;
            resize: vertical;
        }

        input:focus,
        textarea:focus {
            border-color: var(--lavender-2);
            box-shadow: 0 0 0 3px rgba(167, 139, 250, .12);
        }

        .actions {
            display: flex;
            gap: 10px;
            align-items: center;
            flex-wrap: wrap;
            margin-top: 10px;
            grid-column: 1/-1;
        }

        .btn {
            border: 1px solid var(--lavender-2);
            color: #1a1035;
            background: linear-gradient(180deg, var(--lavender) 0%, var(--lavender-2) 100%);
            font-weight: 700;
            padding: 10px 14px;
            border-radius: 8px;
            cursor: pointer;
            transition: filter .15s ease, transform .02s ease;
            text-transform: uppercase;
            letter-spacing: .6px;
            font-size: 12px;
        }

        .btn[disabled] {
            opacity: .6;
            cursor: not-allowed;
            filter: grayscale(.4);
        }

        .btn.secondary {
            background: transparent;
            color: var(--muted);
            border-color: var(--border);
        }

        .status {
            margin-left: auto;
            color: var(--muted);
            display: flex;
            align-items: center;
            gap: 8px;
            min-height: 28px;
        }

        .spinner {
            display: inline-flex;
            width: 18px;
            height: 18px;
            align-items: center;
            justify-content: center;
            border: 1px dashed var(--lavender-2);
            border-radius: 50%;
            opacity: .9;
        }

        .pill {
            display: inline-flex;
            align-items: center;
            gap: 8px;
            padding: 6px 10px;
            border-radius: 999px;
            font-size: 12px;
            border: 1px solid var(--border);
            background: #0c0c13;
            color: var(--muted);
        }

        .ok {
            color: var(--ok);
            border-color: rgba(178, 245, 234, .35);
        }

        .err {
            color: var(--err);
            border-color: rgba(255, 153, 173, .35);
        }

        .sr-only {
            position: absolute;
            width: 1px;
            height: 1px;
            padding: 0;
            margin: -1px;
            overflow: hidden;
            clip: rect(0, 0, 0, 0);
            white-space: nowrap;
            border: 0;
        }

        .monitor .head {
            display: flex;
            align-items: center;
            justify-content: space-between;
            gap: 10px;
            padding: 10px 14px;
            background: linear-gradient(180deg, rgba(196, 181, 253, .10), rgba(196, 181, 253, .04));
            border-bottom: 1px solid var(--border);
            color: var(--muted);
        }

        #llo {
            display: flex !important;
            justify-content: space-between;
        }

        .monitor .body {
            padding: 14px;
        }

        .prompt {
            color: var(--muted);
            margin-bottom: 6px;
            font-size: 12px;
        }

        pre.code {
            margin: 0;
            max-height: 520px;
            overflow: auto;
            white-space: pre-wrap;
            word-break: break-word;
            background: #0e0e15;
            border: 1px solid var(--border);
            border-radius: 8px;
            padding: 12px;
        }

        .kudos {
            display: flex;
            gap: 10px;
            flex-wrap: wrap;
            align-items: center;
            margin-top: 10px;
        }

        .link {
            color: var(--lavender);
            text-decoration: none;
            border-bottom: 1px dotted var(--lavender-2);
        }

        .link:hover {
            text-decoration: underline;
        }

        noscript {
            display: block;
            margin: 16px 0;
            color: var(--err);
            background: #170e1f;
            border: 1px solid rgba(255, 153, 173, .35);
            border-radius: 8px;
            padding: 10px 12px;
        }

        details {
            margin-top: 10px;
        }

        details>summary {
            cursor: pointer;
            color: var(--muted);
        }

        /* Optional fixed heights to mimic the mock proportions on desktop */
        .form-panel {
            min-height: 260px;
        }

        .viz {
            min-height: 320px;
        }

        .viz-canvas {
            width: 100%;
            height: 280px;
            background: #0e0e15;
            border: 1px solid var(--border);
            border-radius: 8px;
        }

        #treeViz svg {
            display: block;
        }

        #treeViz .node text {
            font-family: ui-monospace, SFMono-Regular, Menlo, Monaco, Consolas, "Liberation Mono", monospace;
            font-size: 12px;
            fill: #e8e5ff;
            user-select: none;
        }

        #treeViz .link {
            shape-rendering: geometricPrecision;
        }
    </style>

</head>

<body>
    <div class="wrap" x-data="ideaTerminal()" x-init="$nextTick(() => status = 'Ready. Press Ctrl/Cmd+Enter to run.')" @keydown.ctrl.enter.prevent="submit()"
        @keydown.meta.enter.prevent="submit()">

        <div class="columns">
            <!-- LEFT TOP: input form -->
            <section class="terminal form-panel" role="application" aria-label="Idea Terminal">
                <div class="titlebar">
                    <div class="dot" aria-hidden="true"></div>
                    <div class="dot" aria-hidden="true"></div>
                    <div class="dot" aria-hidden="true"></div>
                    <div class="title">Logos Shell — v1.1</div>
                </div>

                <div class="panel">
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

                    <p class="help">
                        Enter a <strong>Base Topic</strong> and your <strong>Idea Prompt</strong>, then run the
                        terminal.
                        The server will generate the full chain (idea tree → bridges → twist → manual).
                    </p>

                    <noscript>This page requires JavaScript (Alpine.js) to run the terminal.</noscript>

                    <form class="grid" @submit.prevent="submit()" aria-describedby="statusline">
                        <div>
                            <label for="base_topic">Base Topic</label>
                            <input id="base_topic" type="text" x-model.trim="baseTopic"
                                placeholder="e.g., Generative AI for education" required />
                        </div>

                        <div>
                            <label for="user_idea">Idea Prompt</label>
                            <textarea id="user_idea" x-model.trim="userIdea"
                                placeholder="e.g., Generate a concise idea thread with actionable tips." required></textarea>
                        </div>

                        <div class="actions">
                            <button type="submit" class="btn" :disabled="isLoading">
                                <span x-show="!isLoading">Run ▶</span>
                                <span x-show="isLoading" style="display:none;">Running…</span>
                            </button>

                            <button type="button" class="btn secondary" @click="reset()" :disabled="isLoading">Clear
                                Screen</button>

                            <div id="statusline" class="status" aria-live="polite" aria-atomic="true">
                                <span class="pill" :class="error ? 'err' : (response ? 'ok' : '')">
                                    <span x-show="error">✖</span>
                                    <span x-show="!error && response">✔</span>
                                    <span x-show="!error && !response">•</span>
                                    <span x-text="status">Ready.</span>
                                </span>
                            </div>
                        </div>
                    </form>
                </div>
            </section>

            <!-- LEFT BOTTOM: D3 tree visualization -->
            <section class="viz" role="region" aria-label="JSON Tree Visualization">
                <div class="titlebar">
                    <div class="dot" aria-hidden="true"></div>
                    <div class="dot" aria-hidden="true"></div>
                    <div class="dot" aria-hidden="true"></div>
                    <div class="title">Idea Tree (D3)</div>
                </div>
                <div class="panel">
                    <p class="help">D3.js visualization of <code>response.idea_tree</code>.</p>
                    <!-- Give some height so the SVG has room -->
                    <div id="treeViz" class="viz-canvas" aria-label="Tree canvas"
                        style="width:100%; min-height: 220px; height:100%;">
                    </div>
                </div>
            </section>

            <!-- RIGHT: reply/output (spans two rows) -->
            <aside class="monitor span-rows-2" aria-label="Reply Panel">
                <div class="head">
                    <div>Reply</div>
                    <div class="status" aria-live="polite" aria-atomic="true">
                        <span class="pill" :class="error ? 'err' : (response ? 'ok' : '')">
                            <template x-if="isLoading">
                                <span>Working…</span>
                            </template>
                            <template x-if="!isLoading && !response && !error">
                                <span>Idle</span>
                            </template>
                            <template x-if="!isLoading && response && !error">
                                <span>Done</span>
                            </template>
                            <template x-if="error">
                                <span>Error</span>
                            </template>
                        </span>
                    </div>
                </div>

                <div class="body">
                    <!-- Empty state -->
                    <template x-if="!response && !error && !isLoading">
                        <div class="pill" style="display:inline-flex;">No output yet — run a job from the console.
                        </div>
                    </template>

                    <!-- Error -->
                    <template x-if="error">
                        <div>
                            <div class="prompt">[ output ]</div>
                            <pre class="code" style="color: #ff99ad;">ERROR: <span x-text="error"></span></pre>
                        </div>
                    </template>

                    <!-- Success -->
                    <template x-if="response">
                        <div>
                            <div class="prompt">[ input ]</div>
                            <pre class="code" x-text="response?.input ?? ''"></pre>

                            {{-- <div class="prompt" style="margin-top:10px;">[ twisted idea ]</div>
                            <pre class="code" x-text="response?.twisted_idea ?? ''"></pre> --}}

                            <div id="llo"
                                style="padding-block: 0.6rem; display:flex !important; justify-content:space-between; align-items:center; margin-top:10px;"
                                x-show="response.manual_url">
                                <div class="prompt">[ manual ]</div>
                                <a :href="response.manual_url" target="_blank"
                                    style="background-color: var(--lavender); color: var(--bg); padding:4px 10px; border-radius:4px; text-decoration:none; font-weight:bold;">
                                    Open txt
                                </a>
                            </div>

                            <pre class="code" x-text="response?.manual ?? ''"></pre>

                            <details>
                                <summary>[ idea_tree JSON ]</summary>
                                <pre class="code" x-text="JSON.stringify(response?.idea_tree ?? {}, null, 2)"></pre>
                            </details>

                            <details>
                                <summary>[ chosen_bridge ]</summary>
                                <pre class="code" x-text="JSON.stringify(response?.chosen_bridge ?? {}, null, 2)"></pre>
                            </details>

                            <details>
                                <summary>[ semantic_bridges ]</summary>
                                <pre class="code" x-text="JSON.stringify(response?.semantic_bridges ?? [], null, 2)"></pre>
                            </details>



                            <div class="kudos">
                                <span class="pill ok">All set — full chain completed.</span>
                            </div>
                        </div>
                    </template>
                </div>
            </aside>
        </div>

    </div>

    <script>
        function ideaTerminal() {
            return {
                baseTopic: '',
                userIdea: '',
                isLoading: false,
                status: 'Ready.',
                response: null,
                error: null,
                spinnerFrames: ['⠋', '⠙', '⠹', '⠸', '⠼', '⠴', '⠦', '⠧', '⠇', '⠏'],
                spinnerIndex: 0,
                _spinTimer: null,

                csrf() {
                    return document.querySelector('meta[name="csrf-token"]')?.getAttribute('content') || '';
                },

                startSpinner() {
                    if (this._spinTimer) return;
                    this._spinTimer = setInterval(() => {
                        this.spinnerIndex = (this.spinnerIndex + 1) % this.spinnerFrames.length;
                    }, 90);
                },
                stopSpinner() {
                    if (this._spinTimer) {
                        clearInterval(this._spinTimer);
                        this._spinTimer = null;
                    }
                    this.spinnerIndex = 0;
                },

                async submit() {
                    if (!this.baseTopic || !this.userIdea) return;

                    this.isLoading = true;
                    this.response = null;
                    this.error = null;
                    this.status = 'Booting job…';
                    this.startSpinner();

                    try {
                        const want = `${this.baseTopic} — ${this.userIdea}`;
                        const res = await fetch('/terminal', {
                            method: 'POST',
                            headers: {
                                'Content-Type': 'application/json',
                                'Accept': 'application/json',
                                'X-CSRF-TOKEN': this.csrf()
                            },
                            body: JSON.stringify({
                                want
                            })
                        });

                        let data = null;
                        try {
                            data = await res.json();
                        } catch (_) {}

                        if (!res.ok) {
                            const msg = (data && (data.error || data.message)) || `Request failed (${res.status})`;
                            throw new Error(msg);
                        }

                        this.response = data || {};
                        this.status = 'Done. Visualizing tree…';

                        // Render the D3 tree
                        if (this.response.idea_tree) {
                            renderIdeaTree(this.response.idea_tree);
                        } else {
                            const el = document.getElementById('treeViz');
                            if (el) el.innerHTML = '';
                        }

                    } catch (e) {
                        this.error = e.message || 'Unknown error';
                        this.status = 'Something went wrong.';
                    } finally {
                        this.stopSpinner();
                        this.isLoading = false;
                    }
                },

                reset() {
                    this.baseTopic = '';
                    this.userIdea = '';
                    this.response = null;
                    this.error = null;
                    this.status = 'Screen cleared. Ready.';
                    const el = document.getElementById('treeViz');
                    if (el) el.innerHTML = '';
                }
            }
        }

        // -------- D3 TREE RENDERER --------
        function renderIdeaTree(treeData) {
            const container = document.getElementById('treeViz');
            if (!container) return;

            container.innerHTML = '';

            const width = container.clientWidth || 800;
            const height = container.clientHeight || 420;

            const margin = {
                top: 24,
                right: 160,
                bottom: 24,
                left: 160
            };

            const svg = d3.select(container)
                .append('svg')
                .attr('width', '100%')
                .attr('height', '100%')
                .attr('viewBox', [
                    -margin.left,
                    -margin.top,
                    width + margin.left + margin.right,
                    height + margin.top + margin.bottom
                ].join(' '));

            const g = svg.append('g').attr('class', 'content');

            const root = d3.hierarchy(
                treeData,
                d => (d && Array.isArray(d.children)) ? d.children : []
            );

            const treeLayout = d3.tree().size([height, width - 220]);
            treeLayout(root);

            g.append('g')
                .attr('class', 'links')
                .selectAll('path')
                .data(root.links())
                .enter()
                .append('path')
                .attr('fill', 'none')
                .attr('stroke', getComputedStyle(document.documentElement).getPropertyValue('--lavender'))
                .attr('stroke-opacity', 0.7)
                .attr('stroke-width', 1.5)
                .attr('d', d3.linkHorizontal()
                    .x(d => d.y)
                    .y(d => d.x)
                );

            const node = g.append('g')
                .attr('class', 'nodes')
                .selectAll('g')
                .data(root.descendants())
                .enter()
                .append('g')
                .attr('class', 'node')
                .attr('transform', d => `translate(${d.y},${d.x})`);

            node.append('circle')
                .attr('r', 5)
                .attr('fill', d => d.depth === 0 ?
                    getComputedStyle(document.documentElement).getPropertyValue('--ok') :
                    getComputedStyle(document.documentElement).getPropertyValue('--text'))
                .attr('stroke', getComputedStyle(document.documentElement).getPropertyValue('--lavender-2'))
                .attr('stroke-width', 1.5);

            node.append('text')
                .attr('dy', '0.32em')
                .attr('x', d => d.children ? -10 : 10)
                .attr('text-anchor', d => d.children ? 'end' : 'start')
                .attr('fill', getComputedStyle(document.documentElement).getPropertyValue('--text'))
                .text(d => d.data?.topic ?? '(untitled)');

            node.append('title')
                .text(d => (d.data?.topic ? d.data.topic + '\n' : '') + (d.data?.description || ''));

            const zoom = d3.zoom()
                .scaleExtent([0.5, 2])
                .on('zoom', (event) => g.attr('transform', event.transform));

            svg.call(zoom);
            svg.call(zoom.transform, d3.zoomIdentity.translate(40, 20).scale(1));

            let resizeTimer;
            window.addEventListener('resize', () => {
                clearTimeout(resizeTimer);
                resizeTimer = setTimeout(() => renderIdeaTree(treeData), 150);
            }, {
                passive: true
            });
        }
    </script>
</body>

</html>
