<?php $__env->startSection('styles'); ?>
    <!-- Add custom styles -->
    <style>
        .hero-section {
            position: relative;
            overflow: hidden;
            border-radius: 10px;
        }

        .card {
            transition: transform 0.3s ease, box-shadow 0.3s ease;
        }

        .card:hover {
            transform: translateY(-5px);
            box-shadow: 0 10px 20px rgba(0, 0, 0, 0.1) !important;
        }

        .btn {
            transition: all 0.3s ease;
        }

        .btn:hover {
            transform: translateY(-2px);
        }

        .modal-body {
            max-height: 70vh;
            overflow-y: auto;
        }

        .safety-tip-icon {
            width: 80px;
            height: 80px;
            margin-right: 20px;
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 2rem;
        }

        .tip-list {
            padding-left: 20px;
        }

        .tip-list li {
            margin-bottom: 12px;
        }

        .modal-header {
            border-bottom: 3px solid;
        }
    </style>
<?php $__env->stopSection(); ?>
<?php $__env->startSection('content'); ?>
    <!-- Header Section -->
    <div class="container mt-5">
        <div class="row">
            <div class="col-12">
                <div class="card bg-danger text-white hero-section mb-5 hero-image" style="height: 400px;">
                    <div class="card-img-overlay d-flex flex-column justify-content-center text-center">
                        <h1 class="card-title fw-bold">Emergency Safety Guide: Stay Prepared for Any Disaster</h1>
                        <p class="card-text fs-5">Essential tips to keep you and your loved ones safe during emergencies.</p>
                    </div>
                </div>
            </div>
        </div>


        <!-- Main Content - 2x4 Grid Layout -->
        <div class="row row-cols-1 row-cols-md-2 g-4 mb-5">
            <!-- Fire Safety -->
            <div class="col">
                <div class="card h-100 shadow-sm">
                    <div class="row g-0">
                        <div class="col-md-4">
                            <img src="<?php echo e(asset('asset/image/safety-tips/fire.png')); ?>" class="img-fluid rounded-start h-100"
                                alt="Fire Safety" style="object-fit: cover;">
                        </div>
                        <div class="col-md-8">
                            <div class="card-body">
                                <h5 class="card-title"><i class="fas fa-fire text-danger me-2"></i>Fire Safety</h5>
                                <p class="card-text">Learn how to prevent fires and safely evacuate during a fire emergency.
                                </p>
                                <button type="button" class="btn btn-outline-danger" data-bs-toggle="modal"
                                    data-bs-target="#fireSafetyModal">Read More</button>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Flood Preparedness -->
            <div class="col">
                <div class="card h-100 shadow-sm">
                    <div class="row g-0">
                        <div class="col-md-4">
                            <img src="<?php echo e(asset('asset/image/safety-tips/flood.png')); ?>"
                                class="img-fluid rounded-start h-100" alt="Flood Preparedness" style="object-fit: cover;">
                        </div>
                        <div class="col-md-8">
                            <div class="card-body">
                                <h5 class="card-title"><i class="fas fa-water text-primary me-2"></i>Flood Preparedness</h5>
                                <p class="card-text">Steps to prepare for flooding and how to stay safe during flood
                                    conditions.</p>
                                <button type="button" class="btn btn-outline-primary" data-bs-toggle="modal"
                                    data-bs-target="#floodSafetyModal">Read More</button>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Accident Prevention -->
            <div class="col">
                <div class="card h-100 shadow-sm">
                    <div class="row g-0">
                        <div class="col-md-4">
                            <img src="<?php echo e(asset('asset/image/safety-tips/accident.png')); ?>"
                                class="img-fluid rounded-start h-100" alt="Accident Prevention" style="object-fit: cover;">
                        </div>
                        <div class="col-md-8">
                            <div class="card-body">
                                <h5 class="card-title"><i class="fas fa-hospital text-success me-2"></i>Accident Prevention
                                </h5>
                                <p class="card-text">Tips to prevent common accidents and how to respond in case of
                                    emergencies.</p>
                                <button type="button" class="btn btn-outline-success" data-bs-toggle="modal"
                                    data-bs-target="#accidentSafetyModal">Read More</button>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Volcano Eruption Safety -->
            <div class="col">
                <div class="card h-100 shadow-sm">
                    <div class="row g-0">
                        <div class="col-md-4">
                            <img src="<?php echo e(asset('asset/image/safety-tips/volcano.png')); ?>"
                                class="img-fluid rounded-start h-100" alt="Volcano Eruption Safety"
                                style="object-fit: cover;">
                        </div>
                        <div class="col-md-8">
                            <div class="card-body">
                                <h5 class="card-title"><i class="fas fa-mountain text-danger me-2"></i>Volcano Eruption
                                    Safety</h5>
                                <p class="card-text">How to prepare for and respond to volcanic eruptions and ash fall.</p>
                                <button type="button" class="btn btn-outline-danger" data-bs-toggle="modal"
                                    data-bs-target="#volcanoSafetyModal">Read More</button>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Hurricane Survival -->
            <div class="col">
                <div class="card h-100 shadow-sm">
                    <div class="row g-0">
                        <div class="col-md-4">
                            <img src="<?php echo e(asset('asset/image/safety-tips/hurricane.png')); ?>"
                                class="img-fluid rounded-start h-100" alt="Hurricane Survival" style="object-fit: cover;">
                        </div>
                        <div class="col-md-8">
                            <div class="card-body">
                                <h5 class="card-title"><i class="fas fa-wind text-info me-2"></i>Hurricane Survival</h5>
                                <p class="card-text">Preparation strategies and safety measures for before, during, and
                                    after a hurricane.</p>
                                <button type="button" class="btn btn-outline-info" data-bs-toggle="modal"
                                    data-bs-target="#hurricaneSafetyModal">Read More</button>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Virus Outbreak Protection -->
            <div class="col">
                <div class="card h-100 shadow-sm">
                    <div class="row g-0">
                        <div class="col-md-4">
                            <img src="<?php echo e(asset('asset/image/safety-tips/virus.png')); ?>"
                                class="img-fluid rounded-start h-100" alt="Virus Outbreak Protection"
                                style="object-fit: cover;">
                        </div>
                        <div class="col-md-8">
                            <div class="card-body">
                                <h5 class="card-title"><i class="fas fa-virus text-warning me-2"></i>Virus Outbreak
                                    Protection</h5>
                                <p class="card-text">Essential hygiene practices and preventive measures during disease
                                    outbreaks.</p>
                                <button type="button" class="btn btn-outline-warning" data-bs-toggle="modal"
                                    data-bs-target="#virusSafetyModal">Read More</button>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Conflict Safety -->
            <div class="col">
                <div class="card h-100 shadow-sm">
                    <div class="row g-0">
                        <div class="col-md-4">
                            <img src="<?php echo e(asset('asset/image/safety-tips/conflict.png')); ?>"
                                class="img-fluid rounded-start h-100" alt="Conflict Safety" style="object-fit: cover;">
                        </div>
                        <div class="col-md-8">
                            <div class="card-body">
                                <h5 class="card-title"><i class="fas fa-shield-alt text-secondary me-2"></i>Conflict
                                    Safety</h5>
                                <p class="card-text">Guidelines for personal safety during civil unrest or conflict
                                    situations.</p>
                                <button type="button" class="btn btn-outline-secondary" data-bs-toggle="modal"
                                    data-bs-target="#conflictSafetyModal">Read More</button>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Earthquake Readiness -->
            <div class="col">
                <div class="card h-100 shadow-sm">
                    <div class="row g-0">
                        <div class="col-md-4">
                            <img src="<?php echo e(asset('asset/image/safety-tips/earthquake.png')); ?>"
                                class="img-fluid rounded-start h-100" alt="Earthquake Readiness"
                                style="object-fit: cover;">
                        </div>
                        <div class="col-md-8">
                            <div class="card-body">
                                <h5 class="card-title"><i class="fas fa-house-damage text-dark me-2"></i>Earthquake
                                    Readiness</h5>
                                <p class="card-text">How to prepare your home and what to do during and after an
                                    earthquake.</p>
                                <button type="button" class="btn btn-outline-dark" data-bs-toggle="modal"
                                    data-bs-target="#earthquakeSafetyModal">Read More</button>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Fire Safety Modal -->
    <div class="modal fade" id="fireSafetyModal" tabindex="-1" aria-labelledby="fireSafetyModalLabel"
        aria-hidden="true">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <div class="modal-header bg-danger bg-opacity-10" style="border-color: #dc3545;">
                    <div class="d-flex align-items-center">
                        <div class="safety-tip-icon bg-danger text-white">
                            <i class="fas fa-fire"></i>
                        </div>
                        <h5 class="modal-title fs-4" id="fireSafetyModalLabel">Fire Safety Tips</h5>
                    </div>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <div class="row mb-4">
                        <div class="col-md-12">
                            <h5 class="mb-3 text-danger"><i class="fas fa-exclamation-triangle me-2"></i>Prevention</h5>
                            <ul class="tip-list">
                                <li>Install smoke alarms on every level of your home and test them monthly.</li>
                                <li>Keep flammable items at least three feet away from heat sources.</li>
                                <li>Never leave cooking unattended, especially when using oil or high heat.</li>
                                <li>Keep portable heaters at least 3 feet away from anything that can burn.</li>
                                <li>Have your heating system, chimney and vents inspected and cleaned annually.</li>
                                <li>Store matches and lighters out of children's reach and sight.</li>
                            </ul>
                        </div>
                    </div>
                    <div class="row mb-4">
                        <div class="col-md-12">
                            <h5 class="mb-3 text-danger"><i class="fas fa-running me-2"></i>During a Fire</h5>
                            <ul class="tip-list">
                                <li>If you see smoke or flames, immediately alert everyone in the building and call
                                    emergency services.</li>
                                <li>Use the back of your hand to test doors for heat before opening them.</li>
                                <li>If a door is hot, use an alternative escape route.</li>
                                <li>Stay low to the ground where air is clearer if there's smoke.</li>
                                <li>Once you're out, stay out – never go back into a burning building.</li>
                                <li>If your clothes catch fire: Stop, Drop, and Roll to extinguish the flames.</li>
                            </ul>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-12">
                            <h5 class="mb-3 text-danger"><i class="fas fa-first-aid me-2"></i>Evacuation Planning</h5>
                            <ul class="tip-list">
                                <li>Create a home fire escape plan with two ways out of each room.</li>
                                <li>Practice your escape plan with everyone in your household at least twice a year.</li>
                                <li>Designate a meeting place outside that's a safe distance from your home.</li>
                                <li>Make sure everyone knows how to call emergency services.</li>
                                <li>If you live in a high-rise building, know where the exit stairs are located.</li>
                                <li>If you can't escape, close the door, cover vents and cracks around doors with cloth or
                                    tape, and call 911.</li>
                            </ul>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>

                </div>
            </div>
        </div>
    </div>

    <!-- Flood Safety Modal -->
    <div class="modal fade" id="floodSafetyModal" tabindex="-1" aria-labelledby="floodSafetyModalLabel"
        aria-hidden="true">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <div class="modal-header bg-primary bg-opacity-10" style="border-color: #0d6efd;">
                    <div class="d-flex align-items-center">
                        <div class="safety-tip-icon bg-primary text-white">
                            <i class="fas fa-water"></i>
                        </div>
                        <h5 class="modal-title fs-4" id="floodSafetyModalLabel">Flood Preparedness</h5>
                    </div>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <div class="row mb-4">
                        <div class="col-md-12">
                            <b>The safe way to deal with a flood? Go somewhere else. Stay somewhere else. And be absolutely
                                safe when returning to a flood zone. Here's our best advice on how to do that:</b>
                            <h5 class="mb-3 text-primary"><i class="fas fa-clipboard-check me-2"></i>BEFORE A FLOOD (WHEN
                                FLOODING IS FORECAST)</h5>
                            <b>Be alert.</b>
                            <ul class="tip-list">
                                <li>Monitor your surroundings.</li>
                                <li>Monitor NOAA Weather Radio, local television and radio stations, or go to
                                    www.weather.gov.</li>
                            </ul>
                            <b>If a flash flood warning is issued for your area: Climb to safety immediately.</b>
                            <ul class="tip-list">
                                <li>Flash floods develop quickly. Do not wait until you see rising water.</li>
                                <li>Get out of low areas subject to flooding.</li>
                                <li>If driving, do not drive through flooded roadways!</li>
                            </ul>
                            <b>Assemble disaster supplies:</b>
                            <ul class="tip-list">
                                <li>Drinking water – Fill clean containers.</li>
                                <li>Food that requires no refrigeration or cooking.</li>
                                <li>Cash</li>
                                <li>Medications and first aid supplies.</li>
                                <li>Clothing, toiletries.</li>
                                <li>Battery-powered radio.</li>
                                <li>Flashlights.</li>
                                <li>Extra batteries.</li>
                                <li>Important documents: insurance papers, medical records, bank account numbers.</li>
                            </ul>
                            <b>Be prepared to evacuate.</b>
                            <ul class="tip-list">
                                <li>Identify places to go.</li>
                                <li>Identify alternative travel routes that are not prone to flooding.
                                </li>
                                <li>Plan what to do with your pets.</li>
                                <li>Fill your car’s gas tank.</li>
                                <li>If told to leave, do so quickly.</li>
                            </ul>
                            <b>Review your Family Disaster Plan.</b>
                            <ul class="tip-list">
                                <li>Discuss flood plans with your family.</li>
                                <li>Decide where you will meet if separated.
                                </li>
                                <li>Designate a contact person who can be reached if family members get separated. Make sure
                                    every family member has the contact information.
                            </ul>
                            <b>Protect your property.</b>
                            <ul class="tip-list">
                                <li>Move valuables and furniture to higher levels.</li>
                                <li>Move hazardous materials (such as paint, oil, pesticides, and cleaning supplies) to
                                    higher locations.
                                </li>
                                <li>Disconnect electrical appliances. Do not touch them if you are wet or standing in water.
                                </li>
                                <li>Bring outside possessions indoors or tie them down securely. This includes lawn
                                    furniture, garbage cans, and other movable objects.</li>
                                <li>Seal vents to basements to prevent flooding. br</li>
                            </ul>
                        </div>
                    </div>
                    <div class="row mb-4">
                        <div class="col-md-12">
                            <h5 class="mb-3 text-primary"><i class="fas fa-umbrella me-2"></i>During a Flood</h5>
                            <b>Be alert.</b>
                            <ul class="tip-list">
                                <li>Monitor your surroundings.</li>
                                <li>Monitor NOAA Weather Radio, local television and radio stations, or go to
                                    www.weather.gov.</li>
                            </ul>
                            <b>Don’t drive unless you have to. If you must drive, travel with care.</b>
                            <ul class="tip-list">
                                <li>Make sure your vehicle has enough fuel.</li>
                                <li>Follow recommended routes. DO NOT sightsee.</li>
                                <li>Avoid disaster areas. Your presence might hamper rescue or other emergency operations
                                    and put you at further risk.</li>
                                <li>Watch for washed out roads, earth slides, and downed trees or power lines.</li>
                                <li>Be especially cautious at night, when it is harder to recognize flood dangers.</li>
                                <li>If the vehicle stalls, abandon it.</li>
                                <li>If water rises around your car, leave the vehicle immediately. Climb to higher ground as
                                    quickly as possible.</li>
                            </ul>
                            <b>NEVER drive through flooded roadways. STOP! Turn Around Don’t Drown.</b>
                            <ul class="tip-list">
                                <li>The roadbed may be washed out.</li>
                                <li>You can lose control of your vehicle in only a few inches of water.</li>
                                <li>Do not drive around a barricade. Turn around and go another way! </li>
                            </ul>
                            <b>Get to high ground – Climb to safety!</b>
                            <ul class="tip-list">
                                <li>Get out of low areas that may be subject to flooding.</li>
                                <li>Avoid already-flooded areas and do not attempt to cross flowing water.</li>
                                <li>Stay away from power lines and electrical wires.</li>
                            </ul>
                            <b>Evacuate immediately, if you think you are at risk or are advised to do so!</b>
                            <ul class="tip-list">
                                <li>Act quickly. Save yourself, not your belongings.</li>
                                <li>Move to a safe area before access is cut off by rising water.</li>
                                <li>Families should use only one vehicle to avoid getting separated and reduce traffic jams.
                                </li>
                                <li>Shut off water, gas, and electrical services before leaving.</li>
                                <li>Secure your home: lock all doors and windows.</li>
                                <li>If directed to a specific location, go there.</li>
                            </ul>
                            <b>Never try to walk or swim through flowing water.</b>
                            <ul class="tip-list">
                                <li>If flowing water is above your ankles, STOP! Turn around and go another way.</li>
                                <li>If it is moving swiftly, water 6 inches deep can knock you off your feet.</li>
                                <li>Be aware that people have been swept away wading through flood waters.</li>
                                <li>NEVER allow children to play around high water, storm drains, creeks, or rivers.</li>
                            </ul>
                            <b>Shut off the electricity at the circuit breakers.</b>
                            <b>If someone falls in or is trapped in flood water:</b>
                            <ul class="tip-list">
                                <li>Do not go after the victim!</li>
                                <li>If it is moving swiftly, water 6 inches deep can knock you off your feet.</li>
                                <li>Use a floatation device. If possible throw the victim something to help them float, such
                                    as a spare tire, large ball, or foam ice chest.</li>
                                <li>Call for assistance and give the correct location information.</li>
                            </ul>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-12">
                            <h5 class="mb-3 text-primary"><i class="fas fa-house-damage me-2"></i>After a Flood</h5>
                            <b>Wait until it is safe to return. </b>
                            <ul class="tip-list">
                                <li>Monitor PAGASA Weather Radio or local television and radio stations.</li>
                                <li>Do not return to flooded areas until authorities indicate it is safe to do so.</li>
                                <li>Do not visit disaster areas following a flood. Your presence may hamper urgent emergency
                                    response and rescue operations.</li>
                            </ul>
                            <b>Travel with care. </b>
                            <ul class="tip-list">
                                <li>Follow recommended routes. DO NOT sightsee.</li>
                                <li>Watch for washed out roads, earth slides, and downed trees or power lines.</li>
                                <li>Stay away from downed power lines.</li>
                            </ul>
                            <b>If a building was flooded, check for safety before entering. </b>
                            <ul class="tip-list">
                                <li>Do not enter a building if it is still flooded or surrounded by floodwater.</li>
                                <li>Check for structural damage. Inspect foundations for cracks or other damage.</li>
                                <li>Turn off any outside gas lines at the meter tank.</li>
                                <li>Do not enter a building that has flooded until local building officials have inspected
                                    it for safety.</li>
                            </ul>
                            <b>Use extreme caution when entering buildings.</b>
                            <ul class="tip-list">
                                <li>Wear sturdy shoes. The most common injury following a disaster is cut feet.</li>
                                <li>Use ONLY battery-powered lighting. Flammable material may be present.</li>
                                <li>Look for fire hazards (such as damaged gas lines, flooded electrical circuits, or
                                    submerged furnaces).</li>
                                <li>Check for gas leaks. If you smell gas or hear a blowing or hissing noise, open a window
                                    and quickly leave the building. If possible turn off the gas at the outside main valve.
                                    Call the gas company.</li>
                                <li>Report broken utility lines to appropriate authorities.</li>
                                <li>Check for electrical system damage (sparks, broken or frayed wires, or the smell of
                                    burning insulation). Turn off the electricity at the main circuit breaker if you can
                                    reach it without stepping in water.</li>
                                <li>Examine walls, floors, doors, windows, and ceilings for risk of collapsing.</li>
                                <li>Watch out for animals that might have entered with the floodwaters.</li>
                                <li>Let the building air out to remove foul odors or escaping gas.</li>
                            </ul>
                            <b>Take pictures of the damage, both of the building and its contents, for insurance claims. Get
                                professional help.</b>
                            <ul class="tip-list">
                                <li>Seek necessary medical care. Do not neglect minor wounds or illnesses.</li>
                                <li>Food, clothing, shelter, and first aid are available from the American Red Cross.</li>
                                <li>If the gas has been turned off for any reason, it must be turned back on by a
                                    professional.</li>
                                <li>Have an electrician check the electrical system and appliances.</li>
                                <li>Wells should be pumped out and the water tested for purity before drinking.</li>
                            </ul>
                            <b>Your home is no longer a safe place.</b>
                            <ul class="tip-list">
                                <li>Throw away medicine, food, or water that had contact with floodwaters (including canned
                                    goods).</li>
                                <li>If water is of questionable purity, boil drinking water for 10 minutes.</li>
                                <li>Restrict children from playing in flooded areas.</li>
                                <li>Keep windows and doors open for ventilation.</li>
                                <li>Pump out flooded basements gradually (removing about 1/3 of the water volume each day)
                                    to avoid structural damage.</li>
                                <li>Keep the power off until an electrician has inspected the system for safety. All
                                    electrical equipment should be checked and dried before being returned to service.</li>
                                <li>Clean and disinfect everything that got wet.</li>
                                <li>Service damaged sewage systems as soon as possible.</li>
                            </ul>
                            <b>When making repairs, protect your property from future flood damage.</b>
                            <ul class="tip-list">
                                <li>Follow local building codes.</li>
                                <li>Use flood-resistant materials and techniques.</li>
                                <li>Elevate electrical components above the potential flood height.</li>
                                <li>Elevate utilities (washer, dryer, furnace, and water heater) above the level of
                                    anticipated flooding.</li>
                                <li>Consider elevation of the entire structure.</li>
                                <li>Install a backflow valve in the sewer system.</li>
                            </ul>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>

                </div>
            </div>
        </div>
    </div>

    <!-- Accident Prevention Modal -->
    <div class="modal fade" id="accidentSafetyModal" tabindex="-1" aria-labelledby="accidentSafetyModalLabel"
        aria-hidden="true">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <div class="modal-header bg-success bg-opacity-10" style="border-color: #198754;">
                    <div class="d-flex align-items-center">
                        <div class="safety-tip-icon bg-success text-white">
                            <i class="fas fa-hospital"></i>
                        </div>
                        <h5 class="modal-title fs-4" id="accidentSafetyModalLabel">Accident Prevention</h5>
                    </div>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <!-- Accident prevention content goes here -->
                    <div class="row mb-4">
                        <div class="col-md-12">
                            <h5 class="mb-3 text-success"><i class="fas fa-home me-2"></i>Here are some helpful tips
                                small-business owners can use to enhance their safety plans, prevent common workplace
                                accidents and mitigate risks to their business.</h5>
                            <h5 class="mb-3 text-success"><i class="fas fa-home me-2"></i>Avoid slips and falls</h5>
                            <ul class="tip-list">
                                <li>Repair damage to flooring that could cause someone to trip and keep hallways clear of
                                    clutter. Outside, ensure all walkways are shoveled and salted immediately after snow
                                    falls.</li>
                            </ul>
                            <h5 class="mb-3 text-success"><i class="fas fa-home me-2"></i>Be aware of electrical hazards
                            </h5>
                            <ul class="tip-list">
                                <li>If you have several items plugged in at desks, make sure you invest in an
                                    Uninterruptible Power Supply to protect computers and keep the power from spiking. If
                                    renovations are being done that involve electrical systems, move staff to a safe work
                                    area.</li>
                            </ul>
                            <h5 class="mb-3 text-success"><i class="fas fa-home me-2"></i>Limit manual handling and
                                lifting
                            </h5>
                            <ul class="tip-list">
                                <li>If jobs require people to lift items regularly, ensure a system is in place to get at
                                    hard-to-reach items. If they need to lift heavy objects, make sure employees have the
                                    tools they need and know how to operate them safely.</li>
                            </ul>
                            <h5 class="mb-3 text-success"><i class="fas fa-home me-2"></i>Keep a well-stocked first aid
                                kit in plain sight
                            </h5>
                            <ul class="tip-list">
                                <li>If you have a large office, place several kits throughout the area and make sure someone
                                    on staff is trained in first aid.</li>
                            </ul>
                            <h5 class="mb-3 text-success"><i class="fas fa-home me-2"></i>Create an emergency action plan
                            </h5>
                            <ul class="tip-list">
                                <li>Outlines emergency exits, practice fire drills, co-ordinate safe meeting places and
                                    create a system to account for employees’ whereabouts.</li>
                            </ul>
                            <h5 class="mb-3 text-success"><i class="fas fa-home me-2"></i>Identify staff who may need
                                extra help in an emergency
                            </h5>
                            <ul class="tip-list">
                                <li>Involve them in planning for their safety, and make sure the office is accessible,
                                    prepared for fires, power outages and other unexpected events.</li>
                            </ul>
                            <h5 class="mb-3 text-success"><i class="fas fa-home me-2"></i>Promote fire safety
                            </h5>
                            <ul class="tip-list">
                                <li>Identify potential fire hazards in your office and train staff how to use fire
                                    extinguishers.</li>
                            </ul>
                            <h5 class="mb-3 text-success"><i class="fas fa-home me-2"></i>Avoid injuries by storing items
                                safely
                            </h5>
                            <ul class="tip-list">
                                <li>Place heavier items lower to the ground and distribute weight evenly in cabinets and on
                                    shelves.</li>
                            </ul>
                            <h5 class="mb-3 text-success"><i class="fas fa-home me-2"></i>Help reduce back pain and
                                repetitive strain injuries
                            </h5>
                            <ul class="tip-list">
                                <li>Make sure desk chairs are properly adjusted, and computer monitors are at the right
                                    height for each user. Proper ergonomics will aid the longevity and health of staff that
                                    work at desks all day.</li>
                            </ul>
                            <h5 class="mb-3 text-success"><i class="fas fa-home me-2"></i>Protect your business against
                                water damage
                            </h5>
                            <ul class="tip-list">
                                <li>Service HVAC equipment regularly. Pipes and other components in the system can leak,
                                    making the working environment more humid than it should be, which may give rise to
                                    other problems like mould.</li>
                            </ul>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>

                </div>
            </div>
        </div>
    </div>

    <!-- Volcano Eruption Safety Modal -->
    <div class="modal fade" id="volcanoSafetyModal" tabindex="-1" aria-labelledby="volcanoSafetyModalLabel"
        aria-hidden="true">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <div class="modal-header bg-danger bg-opacity-10" style="border-color: #dc3545;">
                    <div class="d-flex align-items-center">
                        <div class="safety-tip-icon bg-danger text-white">
                            <i class="fas fa-mountain"></i>
                        </div>
                        <h5 class="modal-title fs-4" id="volcanoSafetyModalLabel">Volcano Eruption Safety</h5>
                    </div>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <div class="row mb-4">
                        <div class="col-md-12">

                            <h5 class="mb-3 text-danger"><i class="fas fa-home me-2"></i>If a lahar, pyroclastic flow, or
                                lava flow is headed toward you</h5>
                            <ul class="tip-list">
                                <li>Leave the area immediately. If you are warned to evacuate because an eruption is
                                    imminent, evacuate.</li>
                                <li>If you can drive rather than walk, use your vehicle to evacuate. When driving keep doors
                                    and windows closed, drive across the path of danger if you can or away from the danger
                                    if you can not, and watch for unusual hazards in the road.</li>
                            </ul>
                            <h5 class="mb-3 text-danger"><i class="fas fa-home me-2"></i>If you are indoors</h5>
                            <ul class="tip-list">
                                <li>Close all windows, doors, and fireplace or woodstove dampers.</li>
                                <li>Turn off all fans and heating and air conditioning systems.</li>
                                <li>Bring pets and livestock into closed shelters.</li>
                            </ul>
                            <h5 class="mb-3 text-danger"><i class="fas fa-home me-2"></i>If you are indoors</h5>
                            <ul class="tip-list">
                                <li>Close all windows, doors, and fireplace or woodstove dampers.</li>
                                <li>Turn off all fans and heating and air conditioning systems.</li>
                                <li>Bring pets and livestock into closed shelters.</li>
                            </ul>
                            <h5 class="mb-3 text-danger"><i class="fas fa-home me-2"></i>If you are outdoors</h5>
                            <ul class="tip-list">
                                <li>Seek shelter indoors.</li>
                                <li>If caught in a rockfall, roll into a ball to protect your head</li>
                                <li>If near a stream or river, be aware of rising water and possible mudflows in low-lying
                                    areas. Move up-slope as quickly as possible.</li>
                                <li>Seek care for burns right away. Immediate care can be life saving.</li>
                                <li>If your eyes, nose, and throat become irritated from volcanic gases and fumes, move away
                                    from the area immediately. Your symptoms should go away when you are no longer in
                                    contact with the gases or fumes. If the symptoms continue, consult your doctor.</li>
                            </ul>
                        </div>
                    </div>

                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>

                </div>
            </div>
        </div>
    </div>

    <!-- Hurricane Survival Modal -->
    <div class="modal fade" id="hurricaneSafetyModal" tabindex="-1" aria-labelledby="hurricaneSafetyModalLabel"
        aria-hidden="true">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <div class="modal-header bg-info bg-opacity-10" style="border-color: #0dcaf0;">
                    <div class="d-flex align-items-center">
                        <div class="safety-tip-icon bg-info text-white">
                            <i class="fas fa-wind"></i>
                        </div>
                        <h5 class="modal-title fs-4" id="hurricaneSafetyModalLabel">Hurricane Survival</h5>
                    </div>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <div class="row mb-4">
                        <div class="col-md-12">
                            <h5 class="mb-3 text-danger"><i class="fas fa-exclamation-triangle me-2"></i>Hurricane
                                Survival Tips</h5>
                            <ul class="tip-list">
                                <li>Monitor weather reports and don't ignore rainfall warning alerts you receive through
                                    text.</li>
                                <li>Make your own lifeline kit[1] consisting of essential items like food, money, documents,
                                    and toiletries that should last for two to three days.</li>
                                <li>Ensure you have enough food and water supply.</li>
                                <li>Keep the following items handy in case of a power outage: battery-operated radio,
                                    flashlights, spare batteries, rechargeable lamps, and candles.</li>
                                <li>Check your home for anything that needs to be fixed or secured, such as a leaky roof and
                                    trees that need to be trimmed.</li>
                                <li>Park your car in a higher place (like in a mall's parking space) if you live in a
                                    low-lying area.</li>
                                <li>Secure your pets in a safe place.</li>
                                <li>Evacuate immediately and calmly—if there's an order from your local government unit or
                                    if you live near a body of water or mountainsides—to avoid flash floods and landslides.
                                    Close all windows and switch off your main power supply.</li>
                                <li>Make a plan for staying in touch with your family during a typhoon.</li>
                                <li>Keep your phones charged.</li>
                                <li>Keep your phones charged.</li>
                            </ul>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>

                </div>
            </div>
        </div>
    </div>

    <!-- Virus Outbreak Protection Modal -->
    <div class="modal fade" id="virusSafetyModal" tabindex="-1" aria-labelledby="virusSafetyModalLabel"
        aria-hidden="true">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <div class="modal-header bg-warning bg-opacity-10" style="border-color: #ffc107;">
                    <div class="d-flex align-items-center">
                        <div class="safety-tip-icon bg-warning text-dark">
                            <i class="fas fa-virus"></i>
                        </div>
                        <h5 class="modal-title fs-4" id="virusSafetyModalLabel">Virus Outbreak Protection</h5>
                    </div>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <div class="row mb-4">
                        <div class="col-md-12">
                            <b>Avoid exposure</b>
                            <ul class="tip-list">
                                <li>Reducing exposure means following imposed guidelines on quarantine and distancing
                                    yourself from others, especially when COVID-19 is spreading in your community. Stay at
                                    home if you are sick, except to receive urgent medical care.</li>
                            </ul>
                            <b>Observe proper hand hygiene</b>
                            <ul class="tip-list">
                                <li>Hygiene starts with yourself, so practice proper handwashing. According to the World
                                    Health Organization (WHO), the hands are the main pathways to germ transmission.
                                    Remember to wash between your fingers and underyour nails. Avoid touching your eyes,
                                    nose, and mouth with your hands as the virus spreads easily this way.</li>
                            </ul>
                            <b> Key times to wash your hands include:</b>
                            <ul class="tip-list">
                                <li>After blowing one’s nose, coughing or sneezing.</li>
                                <li>After using the restroom</li>
                                <li>Before eating or preparing food</li>
                                <li>After contact with animals</li>
                                <li>Before and after providing care for someone in need of assistance (e.g. a child)</li>
                            </ul>
                            <b>Sanitize your home</b>
                            <ul class="tip-list">
                                <li>Keep your home neat and orderly by practicing regular cleaning and disinfecting, which
                                    both help prevent infection. Regularly clean frequently-touched surfaces, like tables,
                                    doorknobs, light switches, handles, desks, toilets, faucets, and sinks. Remove visible
                                    dirt on carpets and rugs before using appropriate cleaners.</li>
                                <li>Disinfecting means using chemicals like diluted household bleach and solutions with at
                                    least 70 percent rubbing alcohol to remove contamination. Remember to clean dirty
                                    surfaces with detergent or soap and water first before disinfecting.</li>
                            </ul>
                            <b>Check-in on your loved ones</b>
                            <ul class="tip-list">
                                <li>With technology literally at the palm of our hands, connecting with others is easier and
                                    more accessible. Talk to people, especially those you trust, about your concerns and
                                    worries. It is crucial, especially at a time like this, to keep in touch with your loved
                                    ones and see how they are doing.</li>
                                <li>In a pandemic like this, protecting ourselves and those around us can be summed up in
                                    simple habits that start with ourselves and in our own homes. Do your best to stay
                                    healthy, and use your time while on quarantine wisely and productively.</li>
                            </ul>
                            <b>Make use of your health plan</b>
                            <ul class="tip-list">
                                <li>Now is a crucial time to inquire on health plans. Having a health plan gives you a
                                    safety net to support treatment and hospital expenses in the future. As many insurance
                                    firms in the country are now offering assistance for COVID-19 patients, make sure you
                                    and your family have an insurance plan that covers healthcare, especially critical
                                    illnesses.</li>
                            </ul>
                            <b>Take care of your mental health, too</b>
                            <ul class="tip-list">
                                <li>Take occasional breaks from reading, watching and listening to COVID-19-related news,
                                    including social media. While it is good to stay updated and vigilant, repeatedly
                                    consuming content about the health crisis can be upsetting. Find time to unwind and
                                    focus on other activities that you enjoy too. Check out our recommendations on Things to
                                    Do at Home During the Coronavirus Outbreak to get your every day</li>
                            </ul>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>

                </div>
            </div>
        </div>
    </div>

    <!-- Conflict Safety Modal -->
    <div class="modal fade" id="conflictSafetyModal" tabindex="-1" aria-labelledby="conflictSafetyModalLabel"
        aria-hidden="true">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <div class="modal-header bg-secondary bg-opacity-10" style="border-color: #6c757d;">
                    <div class="d-flex align-items-center">
                        <div class="safety-tip-icon bg-secondary text-white">
                            <i class="fas fa-shield-alt"></i>
                        </div>
                        <h5 class="modal-title fs-4" id="conflictSafetyModalLabel">Conflict Safety</h5>
                    </div>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <div class="row mb-4">
                        <div class="col-md-12">
                            <h6 class="mb-3">Accept conflict.
                                Remember that conflict is natural and happens in every ongoing relationship. Since
                                conflict is unavoidable we must learn to manage it. Conflict is a sign of a need for
                                change and an opportunity for growth, new understanding, and improved communication.
                                Conflict can not be resolved unless it is addressed with the appropriate
                                individual(s).</i>
                            </h6>

                            <h6 class="mb-3">Be a calming agent.
                                Regardless of whether you are being a sounding board for a friend or you are dealing
                                with your own conflict, your response to the conflict can escalate or decrease the
                                intensity of the problem. To be calming, provide an objective or neutral point of view.
                                Help plan how you are going to work with the other party to achieve resolution.</i>
                            </h6>
                            <h6 class="mb-3">Listen actively. Work
                                through how you feel, what the specific problem is and what impact it is having on you.
                                Use I -based statements to help do this (see formula below).
                                I feel (strongest feeling)</i>
                            </h6>
                            <ul class="tip-list">
                                <li>When you (objective description of the behavior).</li>
                                <li>Because (specific impact or consequences)</li>
                                <li>I would like (what you want the person to do in the future to prevent the problem)</li>

                            </ul>
                            <h6 class="mb-3">Model neutral
                                language. When people are in conflict they use inflammatory language such as profanity,
                                name calling, and exaggerations that escalate the conflict. Restate inflammatory
                                language in a more objective way to help make the information less emotionally laden and
                                more useful for future discussions</i>
                            </h6>
                            <h6 class="mb-3">Separate the person
                                from the problem. View the problem as a specific behavior or set of circumstances rather
                                than attributing negative feelings to the whole person. This approach makes the problem
                                more manageable and hopeful than deciding you “can’t stand” this person any longer.</i>
                            </h6>
                            <h6 class="mb-3">Work together. This
                                requires that each person stop placing blame and take ownership of the problem. Make a
                                commitment to work together and listen to each other to solve the conflict..</i>
                            </h6>
                            <h6 class="mb-3"> Agree to disagree. Each person has a unique point of view and rarely agrees
                                on every
                                detail.
                                Being right is not what is important. When managing conflict, seeking the “truth” can trap
                                you
                                rather than set you free. For example, consider the differing testimony of witnesses that
                                all
                                see the same car accident. Truth is relative to the person’s point of view.</h6>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>

                </div>
            </div>
        </div>
    </div>

    <!-- Earthquake Readiness Modal -->
    <div class="modal fade" id="earthquakeSafetyModal" tabindex="-1" aria-labelledby="earthquakeSafetyModalLabel"
        aria-hidden="true">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <div class="modal-header bg-dark bg-opacity-10" style="border-color: #212529;">
                    <div class="d-flex align-items-center">
                        <div class="safety-tip-icon bg-dark text-white">
                            <i class="fas fa-house-damage"></i>
                        </div>
                        <h5 class="modal-title fs-4" id="earthquakeSafetyModalLabel">Earthquake Readiness</h5>
                    </div>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <div class="row mb-4">
                        <div class="col-md-12">
                            <h6>Know what to do to keep yourself and your loved ones safe during an earthquake. In most
                                situations, you can protect yourself if you immediately DROP, COVER, and HOLD ON.</h6>
                            <b>Drop. Cover. Hold on.</b>
                            <h6>In most situations, you can protect yourself if you immediately:</h6>
                            <ul class="tip-list">
                                <li><span><strong>DROP down onto your hands and knees</strong></span>before the earthquake
                                    knocks you down. This position protects you from falling but allows you to still move if
                                    necessary.</li>
                                <li><span><strong>COVER your head and neck</strong></span>(and your entire body if possible)
                                    underneath a sturdy table or desk. If there is no shelter nearby, get down near an
                                    interior wall or next to low-lying furniture that won’t fall on you, and cover your head
                                    and neck with your arms and hands.</li>
                                <li><span><strong>HOLD ON to your shelter</strong></span> (or to your head and neck) until
                                    the shaking stops. Be prepared to move with your shelter if the shaking shifts it
                                    around.</li>
                            </ul>
                            <b>If you are inside, stay inside.e</b>
                            <ul class="tip-list">
                                <li>DO NOT run outside or to other rooms during an earthquake. You are less likely to be
                                    injured if you stay where you are.</li>
                            </ul>
                            <b> To reduce your chances of being hurt, take the following actions:</b>
                            <ul class="tip-list">
                                <li>If possible, within the few seconds before shaking intensifies, quickly move away from
                                    glass, hanging objects, bookcases, china cabinets, or other large furniture that could
                                    fall. Watch for falling objects, such as bricks from fireplaces and chimneys, light
                                    fixtures, wall hangings, high shelves, and cabinets with doors that could swing open.
                                </li>
                                <li>If available nearby, grab something to shield your head and face from falling debris and
                                    broken glass.</li>
                                <li>If you are in the kitchen, quickly turn off the stove and take cover at the first sign
                                    of shaking.</li>
                                <li>If you are in bed, hold on and stay there, protecting your head with a pillow. You are
                                    less likely to be injured staying where you are. Broken glass on the floor can cause
                                    injuries if you walk or roll onto the floor.</li>
                            </ul>
                            <b>DO NOT stand in a doorway. You are safer under a table.</b>
                            <ul class="tip-list">
                                <li>In modern houses, doorways are no stronger than any other part of the house. Doorways do
                                    not protect you from the most likely source of injury − falling or flying objects. Most
                                    earthquake-related injuries and deaths are caused by falling or flying objects (such as
                                    TVs, lamps, glass, or bookcases), or by being knocked to the ground.</li>
                            </ul>
                            <b>If you are in a high-rise building, drop, cover, and hold on.</b>
                            <ul class="tip-list">
                                <li>Move away from windows and outside walls</li>
                                <li>Stay in the building.</li>
                                <li>DO NOT use the elevators. The electricity may go out, and the sprinkler systems may come
                                    on.</li>
                                <li>If you are trapped, stay calm. Try to get someone’s attention by tapping on hard or
                                    metal parts of the structure. Doing so may increase your chances of being rescued.</li>
                            </ul>
                            <b>If you are inside a crowded place, drop, cover, and hold on.</b>
                            <ul class="tip-list">
                                <li>Do not rush for the doorways. Others will have the same idea.
                                </li>
                                <li>Move away from display shelves containing objects that may fall.</li>
                                <li>If you can, take cover and grab something to shield your head and face from falling
                                    debris and glass.</li>
                            </ul>
                            <b>If you are outside, stay outside.</b>
                            <ul class="tip-list">
                                <li>Move away from buildings, utility wires, sinkholes, and fuel and gas lines. The greatest
                                    danger from falling debris is just outside doorways and close to outer walls of
                                    buildings.</li>
                                <li>Go to an open area away from trees, telephone poles, and buildings. Once in the open,
                                    get down low and stay there until the shaking stops.</li>
                                <li>The area near the outside walls of a building is the most dangerous place to be.
                                    Windows, facades, and architectural details are often the first parts of the building to
                                    collapse. Stay away from this danger zone.</li>
                            </ul>
                            <b>If you are in a moving vehicle, stop as quickly and safely as possible.</b>
                            <ul class="tip-list">
                                <li>Move your car to the shoulder or curb, away from utility poles, overhead wires, and
                                    under- or overpasses.</li>
                                <li>Stay in the car and set the parking brake. A car may jiggle violently on its springs,
                                    but it is a good place to stay until the shaking stops.</li>
                                <li>Turn on the radio for emergency broadcast information.</li>
                                <li>If a power line falls on the car, stay inside until a trained person removes the wire.
                                </li>
                                <li>When it is safe to begin driving again, watch for hazards created by the earthquake,
                                    such as breaks in the pavement, downed utility poles and wires, rising water levels,
                                    fallen overpasses, or collapsed bridges.</li>
                            </ul>
                            <b>If you are in a stadium or theater, stay in your seat. Protect your head and neck with your
                                arms or any way possible.</b>
                            <ul class="tip-list">
                                <li>Do not leave until the shaking is over.</li>
                                <li>Walk out carefully watching for anything that could fall during the aftershocks.</li>
                            </ul>
                            <b>If you are near the shore, drop, cover, and hold on until the shaking stops.</b>
                            <ul class="tip-list">
                                <li>If severe shaking lasts 20 seconds or more, immediately evacuate to high ground as a
                                    tsunami might have been generated by the earthquake.</li>
                                <li>Move inland 2 miles (3 kilometers) or to land that is at least 100 feet (30 meters)
                                    above sea level immediately. Don’t wait for officials to issue a warning.</li>
                                <li>Walk quickly, rather than drive, to avoid traffic, debris, and other hazards.</li>
                            </ul>
                            <b>If you cannot drop to the ground, try to sit or remain seated so you are not knocked
                                down.</b>
                            <ul class="tip-list">
                                <li>If you are in a wheelchair, lock your wheels. Remove any items that are not securely
                                    attached to the wheelchair.</li>
                                <li>Protect your head and neck with a large book, a pillow, or your arms. The goal is to
                                    prevent injuries from falling down or from objects that might fall or be thrown at you.
                                </li>
                                <li>If you are able, seek shelter under a sturdy table or desk. Stay away from outer walls,
                                    windows, fireplaces, and hanging objects.</li>
                                <li>If you are unable to move from a bed or chair, protect yourself from falling objects by
                                    covering up with blankets and pillows.</li>
                                <li>If you are outside, go to an open area away from trees, telephone poles, and buildings,
                                    and stay there.</li>
                            </ul>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                </div>
            </div>
        </div>
    </div>
<?php $__env->stopSection(); ?>

<?php $__env->startSection('scripts'); ?>
    <script>
        // Additional JavaScript can be added here if needed
        document.addEventListener('DOMContentLoaded', function() {
            // This ensures Bootstrap's JavaScript components are properly initialized
            var tooltipTriggerList = [].slice.call(document.querySelectorAll('[data-bs-toggle="tooltip"]'))
            var tooltipList = tooltipTriggerList.map(function(tooltipTriggerEl) {
                return new bootstrap.Tooltip(tooltipTriggerEl)
            })
        });
    </script>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.landing', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH C:\xampp\htdocs\heroes-app\resources\views/website/safetyguide.blade.php ENDPATH**/ ?>