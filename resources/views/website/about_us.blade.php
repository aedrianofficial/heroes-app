@extends('layouts.landing')
@section('content')
  <div class="container py-5">
    <div class="row mb-5">
      <div class="col-lg-12 text-center">
        {{-- <h1 class="display-4 fw-bold text-danger mb-3">About HEROES APP</h1> --}}
        <p class="lead">Organized Network of Enterprise Application for the People of Aparri thru Relevant and Responsive Data-Driven Information Systems</p>
        <hr class="my-4 mx-auto" style="width: 50%;">
      </div>
    </div>

    <div class="row align-items-center mb-5">
      <div class="col-lg-6">
        <img src="{{ asset('asset/image/lguhouse.jpg') }}" alt="Data-driven decision making" class="img-fluid rounded shadow-lg">
      </div>
      <div class="col-lg-6">
        <h2 class="fw-bold text-danger mb-3">Our Mission</h2>
        <p>Data has become the new oil that drives organizational decision-making and implementation of data-driven policy. It has become crucial to any organization, big or small, private or government, in forecasting, planning, procurement, budget allocation, project development, and program implementation.</p>
        <p>The Municipality of Aparri, being a renowned 1st class municipality and an SGLG recipient for years, has set forth a culture of excellence in different areas. This is basically because of the great leadership and management, full cooperation of the people and government officials from the barangay to the municipal level.</p>
      </div>
    </div>

    <div class="row align-items-center mb-5 flex-lg-row-reverse">
      <div class="col-lg-6">
        <img src="{{ asset('asset/image/community.jpg') }}" alt="Community connection" class="img-fluid rounded shadow-lg">
      </div>
      <div class="col-lg-6">
        <h2 class="fw-bold text-danger mb-3">Why ONEAPARRI?</h2>
        <p>Disaster preparedness, planning, intervention programs and related activities are highly dependent upon an organized data set or information of the organization or the local government unit like Aparri.</p>
        <p>More often than not, local government officials are challenged with the question of what is the first connection they have with citizens. The LGU's website can be one of the most essential tools for meeting the needs of the citizens, and so optimizing it around the citizen experience is crucial.</p>
      </div>
    </div>

    <div class="row mb-5">
      <div class="col-lg-12">
        <div class="card border-0 bg-light shadow">
          <div class="card-body p-5">
            <h2 class="fw-bold text-danger mb-4 text-center">What is ONEAPARRI?</h2>
            <p>ONEAPARRI or <strong>Organized Network of Enterprise Application for the People of Aparri thru Relevant and Responsive Data-Driven Information Systems</strong>, is an innovative solution that hopes to greatly aid in the data-driven decision support and knowledge-based policy recommendation towards an improved delivery of services via utilization of a centralized database of community profile.</p>
            <p>The project generally aims to analyze, design, develop, implement and train different stakeholders of a relevant and responsive data-driven information system accessible in an online platform anytime or 24/7 and anywhere.</p>
          </div>
        </div>
      </div>
    </div>

    <div class="row mb-5">
      <div class="col-lg-12 text-center">
        <h2 class="fw-bold text-danger mb-4">Key Features</h2>
      </div>
      <div class="col-md-6 col-lg-4 mb-4">
        <div class="card h-100 border-0 shadow-sm">
          <div class="card-body p-4">
            <div class="text-center mb-3">
              <i class="bi bi-clock-history text-danger" style="font-size: 2.5rem;"></i>
            </div>
            <h4 class="card-title text-center">24/7 Access</h4>
            <p class="card-text">Responsive and real-time 24/7 access to and dissemination of relevant and reliable information and updates thru the integrated web portal.</p>
          </div>
        </div>
      </div>
      <div class="col-md-6 col-lg-4 mb-4">
        <div class="card h-100 border-0 shadow-sm">
          <div class="card-body p-4">
            <div class="text-center mb-3">
              <i class="bi bi-database-check text-danger" style="font-size: 2.5rem;"></i>
            </div>
            <h4 class="card-title text-center">Centralized Databank</h4>
            <p class="card-text">Centralized databank of the LGU comprising the residents' profile, housing profile, agricultural-related profile, barangay-related profile and other relevant data from the 42 barangays of Aparri Cagayan.</p>
          </div>
        </div>
      </div>
      <div class="col-md-6 col-lg-4 mb-4">
        <div class="card h-100 border-0 shadow-sm">
          <div class="card-body p-4">
            <div class="text-center mb-3">
              <i class="bi bi-graph-up-arrow text-danger" style="font-size: 2.5rem;"></i>
            </div>
            <h4 class="card-title text-center">Data Analytics</h4>
            <p class="card-text">Basic data analytics for delivery units crucial for decision-making activities and policy development.</p>
          </div>
        </div>
      </div>
      <div class="col-md-6 col-lg-4 mb-4">
        <div class="card h-100 border-0 shadow-sm">
          <div class="card-body p-4">
            <div class="text-center mb-3">
              <i class="bi bi-phone text-danger" style="font-size: 2.5rem;"></i>
            </div>
            <h4 class="card-title text-center">Mobile Responsive</h4>
            <p class="card-text">Mobile and cross-platform responsive access of the web portal.</p>
          </div>
        </div>
      </div>
      <div class="col-md-6 col-lg-4 mb-4">
        <div class="card h-100 border-0 shadow-sm">
          <div class="card-body p-4">
            <div class="text-center mb-3">
              <i class="bi bi-piggy-bank text-danger" style="font-size: 2.5rem;"></i>
            </div>
            <h4 class="card-title text-center">Cost-Effective</h4>
            <p class="card-text">Low-cost innovative ICT technologies compared to commercial-off-the-shelf applications.</p>
          </div>
        </div>
      </div>
      <div class="col-md-6 col-lg-4 mb-4">
        <div class="card h-100 border-0 shadow-sm">
          <div class="card-body p-4">
            <div class="text-center mb-3">
              <i class="bi bi-headset text-danger" style="font-size: 2.5rem;"></i>
            </div>
            <h4 class="card-title text-center">User Support</h4>
            <p class="card-text">Intuitive and user-adoptive web and database interfaces with 24/7 user-support and feedback mechanism.</p>
          </div>
        </div>
      </div>
    </div>

    <div class="row">
      <div class="col-lg-12 text-center">
        <div class="card bg-danger text-white border-0">
          <div class="card-body p-5">
            <h2 class="fw-bold mb-4">Join Us in Building a Better Aparri</h2>
            <p class="lead">Together, we can utilize data-driven approaches to improve services and community development.</p>
            <a href="#" class="btn btn-light btn-lg px-4 mt-3">Contact Us</a>
          </div>
        </div>
      </div>
    </div>
  </div>
@endsection