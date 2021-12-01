Dashboard




<template>
  <app-layout title="Dashboard">
    <template #header>
      <h2>
        LEAD Dashboard
      </h2>
      <p>
        Omnis dio. Lorectatur? Luptatquibus parum renditi…
      </p>
    </template>

    <div class="card">
      <div class="stats">
        <div class="stats__item">
          <div class="stats__card stats__card--purple">
            <div class="stats__card-inner">
              <div class="stats__card-title">
                Planned
                <div class="stats__card-title-icon">
                  <Icon icon="calendar" />
                </div>
              </div>
              <div class="stats__card-stat">
                00
              </div>
              <div class="stats__card-footer">
                <div class="stats__card-footer-title">
                  Engagements
                </div>
                Per KEE in Q1
              </div>
            </div>
          </div>
        </div>
        <div class="stats__item">
          <div class="stats__card stats__card--orange">
            <div class="stats__card-inner">
              <div class="stats__card-title">
                Actual
                <div class="stats__card-title-icon">
                  <Icon icon="person" />
                </div>
              </div>
              <div class="stats__card-stat">
                00
                <span class="stats__card-stat-small">
                                    /00<sup>%</sup>
                                </span>
              </div>
              <div class="stats__card-footer">
                <div class="stats__card-footer-title">
                  Engagements
                </div>
                Per KEE in Q1
              </div>
            </div>
          </div>
        </div>
        <div class="stats__item">
          <div class="stats__card stats__card--green">
            <div class="stats__card-inner">
              <div class="stats__card-title">
                Total Actual
                <div class="stats__card-title-icon">
                  21
                </div>
              </div>
              <div class="stats__card-stat">
                00
                <span class="stats__card-stat-small">
                                    /00<sup>%</sup>
                                </span>
              </div>
              <div class="stats__card-footer">
                <div class="stats__card-footer-title">
                  Engagements
                </div>
                Per KEE for the year
              </div>
            </div>
          </div>
        </div>
        <div class="stats__item">
          <div class="stats__card stats__card--blue">
            <div class="stats__card-inner">
              <div class="stats__card-title">
                KEE Rankings
                <div class="stats__card-title-icon">
                  <Icon icon="star" />
                </div>
              </div>
              <div class="stats__card-stat">
                00
                <span class="stats__card-stat-small">
                                    /00<sup>%</sup>
                                </span>
              </div>
              <div class="stats__card-footer">
                <div class="stats__card-footer-title">
                  A - Grade
                </div>
                N<sup>o</sup> of KEEs Graded A
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>

    <div class="card">
      <div class="card__heading">
        <h2 class="card__title">
          Upcoming Engagements
        </h2>
        <div class="card__heading-button">
          <a href="#" class="button">
            Calendar
          </a>
        </div>
      </div>
      <table class="table">
        <thead>
        <th>
          Name
        </th>
        <th>
          Date/Time
        </th>
        <th>
          Data
        </th>
        <th>
          Location
        </th>
        <th>
          Action
        </th>
        </thead>
        <tr>
          <td>
            <div class="table__cell-with-icon">
                            <span class="table__icon">
                                <Icon icon="location" />
                            </span>
              Engagements N
            </div>
          </td>
          <td>
            00/00/00 00:00
          </td>
          <td>
            Early
          </td>
          <td>
            London, UK
          </td>
          <td class="table__buttons">
            <div class="buttons-group">
              <a href="#" class="button button--small">
                View
              </a>
              <a href="#" class="button button--small button--green">
                                <span class="button__icon">
                                    <Icon icon="edit" />
                                </span>
                Edit
              </a>
              <a href="#" class="button button--small button--red">
                                <span class="button__icon">
                                    <Icon icon="trash" />
                                </span>
                Delete
              </a>
            </div>
          </td>
        </tr>
        <tr class="table__spacer">
          <td colspan="5"></td>
        </tr>
        <tr>
          <td>
            <div class="table__cell-with-icon">
                            <span class="table__icon">
                                <Icon icon="location" />
                            </span>
              Engagements N
            </div>
          </td>
          <td>
            00/00/00 00:00
          </td>
          <td>
            Early
          </td>
          <td>
            London, UK
          </td>
          <td class="table__buttons">
            <div class="buttons-group">
              <a href="#" class="button button--small">
                View
              </a>
              <a href="#" class="button button--small button--green">
                                <span class="button__icon">
                                    <Icon icon="edit" />
                                </span>
                Edit
              </a>
              <a href="#" class="button button--small button--red">
                                <span class="button__icon">
                                    <Icon icon="trash" />
                                </span>
                Delete
              </a>
            </div>
          </td>
        </tr>
        <tr class="table__spacer">
          <td colspan="5"></td>
        </tr>
        <tr>
          <td>
            <div class="table__cell-with-icon">
                            <span class="table__icon">
                                <Icon icon="location" />
                            </span>
              Engagements N
            </div>
          </td>
          <td>
            00/00/00 00:00
          </td>
          <td>
            Early
          </td>
          <td>
            London, UK
          </td>
          <td class="table__buttons">
            <div class="buttons-group">
              <a href="#" class="button button--small">
                View
              </a>
              <a href="#" class="button button--small button--green">
                                <span class="button__icon">
                                    <Icon icon="edit" />
                                </span>
                Edit
              </a>
              <a href="#" class="button button--small button--red">
                                <span class="button__icon">
                                    <Icon icon="trash" />
                                </span>
                Delete
              </a>
            </div>
          </td>
        </tr>
      </table>
    </div>
    <div class="card">
      <div class="card__heading">
        <h2 class="card__title">
          Recently Evaluated KEEs
        </h2>
        <div class="card__heading-button">
          <a href="#" class="button">
            KEE Ranking
          </a>
        </div>
      </div>
      <table class="table">
        <thead>
        <th>
          Name
        </th>
        <th>
          Specialism
        </th>
        <th>
          Ranking
        </th>
        <th>
          Data
        </th>
        <th>
          Commitment
        </th>
        <th>
          Performance
        </th>
        <th>
          Action
        </th>
        </thead>
        <tr>
          <td>
            <div class="table__cell-with-icon">
                            <span class="table__icon">
                                <Icon icon="person" />
                            </span>
              Sarah Smith
            </div>
          </td>
          <td>
            Surgery
          </td>
          <td>
            B
          </td>
          <td>
            Expert
          </td>
          <td>
            Medium
          </td>
          <td>
            Advanced
          </td>
          <td class="table__buttons">
            <div class="buttons-group">
              <a href="#" class="button button--small">
                View
              </a>
              <a href="#" class="button button--small button--green">
                Schedule
              </a>
            </div>
          </td>
        </tr>
        <tr class="table__spacer">
          <td colspan="5"></td>
        </tr>
        <tr>
          <td>
            <div class="table__cell-with-icon">
                            <span class="table__icon">
                                <Icon icon="person" />
                            </span>
              Sarah Smith
            </div>
          </td>
          <td>
            Surgery
          </td>
          <td>
            B
          </td>
          <td>
            Expert
          </td>
          <td>
            Medium
          </td>
          <td>
            Advanced
          </td>
          <td class="table__buttons">
            <div class="buttons-group">
              <a href="#" class="button button--small">
                View
              </a>
              <a href="#" class="button button--small button--green">
                Schedule
              </a>
            </div>
          </td>
        </tr>
        <tr class="table__spacer">
          <td colspan="5"></td>
        </tr>
        <tr>
          <td>
            <div class="table__cell-with-icon">
                            <span class="table__icon">
                                <Icon icon="person" />
                            </span>
              Sarah Smith
            </div>
          </td>
          <td>
            Surgery
          </td>
          <td>
            B
          </td>
          <td>
            Expert
          </td>
          <td>
            Medium
          </td>
          <td>
            Advanced
          </td>
          <td class="table__buttons">
            <div class="buttons-group">
              <a href="#" class="button button--small">
                View
              </a>
              <a href="#" class="button button--small button--green">
                Schedule
              </a>
            </div>
          </td>
        </tr>
      </table>
    </div>
    <div class="card card--narrow">
      <div class="card__heading">
        <h2 class="card__title">
          Roles Table
        </h2>
      </div>
      <div class="table-border-container">
        <table class="table table--border">
          <thead>
          <th>
            ID
          </th>
          <th>
            Name
          </th>
          </thead>
          <tr>
            <td>
              1
            </td>
            <td>
              Super Admin
            </td>
          </tr>
          <tr>
            <td>
              2
            </td>
            <td>
              Admin
            </td>
          </tr>
          <tr>
            <td>
              3
            </td>
            <td>
              Member
            </td>
          </tr>
        </table>
      </div>
    </div>
    <EngagementForm />
    <div class="card card--narrowest card--center">
      <div class="card__inner">
                <span class="icon icon--green-gradient">
                    <Icon icon="tick" />
                </span>
        <h2 class="title">
          Complete
        </h2>
        <div class="card__content">
          <p>
            A new user has been added/edited
          </p>
        </div>
        <a href="#" class="button">
          Return
        </a>
      </div>
    </div>
    <button @click="showModal()">
      Delete User
    </button>
    <transition name="fade">
      <div class="modal" v-if="modalActive === true">
        <div class="modal__inner">
          <div class="card card--narrowest card--center">
            <div class="card__inner">
                            <span class="icon icon--red">
                                <Icon icon="trash-large" />
                            </span>
              <h2 class="title">
                Delete User
              </h2>
              <div class="card__content card__content--max-width">
                <p>
                  Are you sure you want to delete this user?
                </p>
              </div>
              <div class="buttons-group">
                <button @click="hideModal()" class="button">
                  Cancel
                </button>
                <button @click="hideModal()" class="button button--red">
                                    <span class="button__icon">
                                        <Icon icon="trash" />
                                    </span>
                  Delete
                </button>
              </div>
            </div>
          </div>
        </div>
      </div>
    </transition>
    <div class="card card--narrowest card--center">
      <div class="card__heading">
        <h2 class="card__title">
          User Profile
        </h2>
        <div class="card__heading-button">
          <a href="#" class="button">
            Edit
          </a>
        </div>
      </div>
      <div class="card__inner">
        <img class="profile-image" src="../../images/placeholder-profile.jpg">
        <div class="card__content">
          <p>
            Dr Sarah Smith
          </p>
          <p>
            <a href="mailto:sarah.smith@gmail.com">
              sarah.smith@gmail.com
            </a>
          </p>
          <p>
            Super Admin
          </p>
        </div>
      </div>
    </div>


    <!-- KEE Profile -->
    <div class="card card--extra-padding">
      <div class="card__heading">
        <h2 class="card__title">
          KEE Ranking
        </h2>
        <div class="card__heading-button">
          <div class="button-group">
            <a href="#" class="button button--small">
              Back
            </a>
            <a href="#" class="button button--small">
              Engagements
            </a>
            <a href="#" class="button button--small">
              History
            </a>
            <a href="#" class="button button--small">
              Publications
            </a>
            <a href="#" class="button button--small button--green">
              Schedule
            </a>
          </div>
        </div>
      </div>
      <div class="profile profile-grid">
        <div class="profile-grid__first">
          <img class="profile-image" src="../../images/placeholder-profile.jpg">
          <table class="profile__details">
            <tr>
              <td class="profile__details-title">
                Title...
              </td>
              <td>
                Dr
              </td>
            </tr>
            <tr>
              <td class="profile__details-title">
                First Name:
              </td>
              <td>
                Sarah
              </td>
            </tr>
            <tr>
              <td class="profile__details-title">
                Last Name:
              </td>
              <td>
                Smith
              </td>
            </tr>
            <tr>
              <td class="profile__details-title">
                Email:
              </td>
              <td>
                sarah.smith@gmail.com
              </td>
            </tr>
            <tr>
              <td class="profile__details-title">
                Specialism:
              </td>
              <td>
                Onocology
              </td>
            </tr>
            <tr>
              <td class="profile__details-title">
                Place of Work:
              </td>
              <td>
                Royal Berkshire NHS
              </td>
            </tr>
            <tr>
              <td class="profile__details-title">
                City:
              </td>
              <td>
                Leicester
              </td>
            </tr>
            <tr>
              <td class="profile__details-title">
                Country:
              </td>
              <td>
                United Kindom
              </td>
            </tr>
          </table>
          <a href="#" class="button">
            H1 Profile Link
          </a>
        </div>
        <div class="profile-grid__second">
          <div class="profile__rankings">
            <div class="profile__rankings-current">
              <div class="profile__rankings-rank">
                <img src="../../images/icon-award-advanced.svg">
              </div>
              <div class="profile__rankings-grade">
                <div class="profile__rankings-text profile__rankings-text--grey">
                  Rank: Advanced
                </div>
                <div class="profile__rankings-text">
                  Grade: B
                </div>
                <img src="../../images/icon-grade-b.svg" class="profile__rankings-grade-icon">
              </div>
              <div class="profile__ranking-date">
                00/00/00
              </div>
            </div>
            <div class="profile__rankings-previous">
              <div class="profile__rankings-text profile__rankings-text--full profile__rankings-text--grey">
                Previous Rank: General
              </div>
              <div class="profile__rankings-rank">
                <img src="../../images/icon-award-general.svg">
              </div>
              <div class="profile__rankings-grade">
                <div class="profile__rankings-text">
                  Grade: C
                </div>
                <img src="../../images/icon-grade-c.svg" class="profile__rankings-grade-icon">
              </div>
              <div class="profile__ranking-date">
                00/00/00
              </div>
            </div>
          </div>
          <div class="profile-chart">
            <h2 class="title-small">
              Understanding of Data:
            </h2>
            <div class="profile-chart__labels">
              <div class="profile-chart__label">
                                <span>
                                    Basic
                                </span>
              </div>
              <div class="profile-chart__label">
                                <span>
                                    General
                                </span>
              </div>
              <div class="profile-chart__label">
                                <span>
                                    Advanced
                                </span>
              </div>
              <div class="profile-chart__label">
                                <span>
                                    Expert
                                </span>
              </div>
            </div>
            <div class="profile-chart__graph">
              <span class="profile-chart__bar profile-chart__bar--empty" style="width: 66.66%;"></span>
            </div>
          </div>
          <div class="profile-chart">
            <h2 class="title-small">
              Commitment:
            </h2>
            <div class="profile-chart__labels">
              <div class="profile-chart__label">
                                <span>
                                    Low
                                </span>
              </div>
              <div class="profile-chart__label">
                                <span>
                                    Medium
                                </span>
              </div>
              <div class="profile-chart__label">
                                <span>
                                    High
                                </span>
              </div>
            </div>
            <div class="profile-chart__graph">
              <span class="profile-chart__bar profile-chart__bar--gradient profile-chart__bar--empty" style="width: 50%;"></span>
            </div>
          </div>
          <div class="profile-chart">
            <h2 class="title-small">
              Performance/Delivery:
            </h2>
            <div class="profile-chart__labels">
              <div class="profile-chart__label">
                                <span>
                                    Basic
                                </span>
              </div>
              <div class="profile-chart__label">
                                <span>
                                    General
                                </span>
              </div>
              <div class="profile-chart__label">
                                <span>
                                    Advanced
                                </span>
              </div>
              <div class="profile-chart__label">
                                <span>
                                    Expert
                                </span>
              </div>
            </div>
            <div class="profile-chart__graph">
              <span class="profile-chart__bar profile-chart__bar--empty" style="width: 33.33%;"></span>
            </div>
          </div>
          <hr>
          <h2 class="title-large">
            Clinical Trial
          </h2>
          <div class="profile-chart">
            <h2 class="title-small">
              FLAURA
            </h2>
            <div class="profile-chart__labels">
              <div class="profile-chart__label">
                                <span>
                                    Basic
                                </span>
              </div>
              <div class="profile-chart__label">
                                <span>
                                    General
                                </span>
              </div>
              <div class="profile-chart__label">
                                <span>
                                    Advanced
                                </span>
              </div>
              <div class="profile-chart__label">
                                <span>
                                    Expert
                                </span>
              </div>
            </div>
            <div class="profile-chart__graph">
              <span class="profile-chart__bar profile-chart__bar--empty" style="width: 33.33%;"></span>
            </div>
          </div>
          <div class="profile-chart">
            <h2 class="title-small">
              MYKONOS
            </h2>
            <div class="profile-chart__labels">
              <div class="profile-chart__label">
                                <span>
                                    Basic
                                </span>
              </div>
              <div class="profile-chart__label">
                                <span>
                                    General
                                </span>
              </div>
              <div class="profile-chart__label">
                                <span>
                                    Advanced
                                </span>
              </div>
              <div class="profile-chart__label">
                                <span>
                                    Expert
                                </span>
              </div>
            </div>
            <div class="profile-chart__graph">
              <span class="profile-chart__bar profile-chart__bar--empty" style="width: 100%;"></span>
            </div>
          </div>
        </div>
      </div>
    </div>



    <!-- KEE Evaluate -->
    <div class="card card--extra-padding">
      <div class="card__heading card__heading--grid">
        <h2 class="card__title card__title--shrink">
          KEE Profile
        </h2>
        <div class="card__title">
          Evaluate
        </div>
        <div class="card__heading-button">
          <div class="button-group">
            <a href="#" class="button button--small">
              Save
            </a>
          </div>
        </div>
      </div>
      <div class="profile profile-grid">
        <div class="profile-grid__first">
          <img class="profile-image" src="../../images/placeholder-profile.jpg">
          <table class="profile__details">
            <tr>
              <td class="profile__details-title">
                Title...
              </td>
              <td>
                Dr
              </td>
            </tr>
            <tr>
              <td class="profile__details-title">
                First Name:
              </td>
              <td>
                Sarah
              </td>
            </tr>
            <tr>
              <td class="profile__details-title">
                Last Name:
              </td>
              <td>
                Smith
              </td>
            </tr>
            <tr>
              <td class="profile__details-title">
                Email:
              </td>
              <td>
                sarah.smith@gmail.com
              </td>
            </tr>
            <tr>
              <td class="profile__details-title">
                Specialism:
              </td>
              <td>
                Onocology
              </td>
            </tr>
            <tr>
              <td class="profile__details-title">
                Place of Work:
              </td>
              <td>
                Royal Berkshire NHS
              </td>
            </tr>
            <tr>
              <td class="profile__details-title">
                City:
              </td>
              <td>
                Leicester
              </td>
            </tr>
            <tr>
              <td class="profile__details-title">
                Country:
              </td>
              <td>
                United Kindom
              </td>
            </tr>
          </table>
          <a href="#" class="button">
            H1 Profile Link
          </a>
        </div>
        <div class="profile-grid__second">
          <h2 class="form__item-heading">
            Did they attend?
          </h2>
          <div class="form__item form__inline">
            <div class="form__inline-item">
              <label for="attend-yes">
                <input type="radio" id="attend-yes" name="attend" value="Yes" checked>
                Yes
              </label>
            </div>
            <div class="form__inline-item">
              <label for="attend-no">
                <input type="radio" id="attend-no" name="attend" value="No">
                No
              </label>
            </div>
          </div>
          <div class="profile-chart">
            <h2 class="title-small">
              Understanding of Data:
            </h2>
            <div class="profile-chart__labels">
              <div class="profile-chart__label">
                                <span>
                                    Basic
                                </span>
              </div>
              <div class="profile-chart__label">
                                <span>
                                    General
                                </span>
              </div>
              <div class="profile-chart__label">
                                <span>
                                    Advanced
                                </span>
              </div>
              <div class="profile-chart__label">
                                <span>
                                    Expert
                                </span>
              </div>
            </div>
            <div class="profile-chart__graph">
              <span class="profile-chart__bar profile-chart__bar--empty"></span>
            </div>
            <div class="form__required profile__select">
              <select class="chart-select" v-on:change="onChartChange($event)">
                <option disabled hidden>
                  Evaluate
                </option>
                <option selected value="Basic" data-percentage="0%">
                  Basic
                </option>
                <option value="General" data-percentage="33.33%">
                  General
                </option>
                <option value="Advanced" data-percentage="66.66%">
                  Advanced
                </option>
                <option value="Expert" data-percentage="100%">
                  Expert
                </option>
              </select>
            </div>
          </div>
          <div class="profile-chart">
            <h2 class="title-small">
              Commitment:
            </h2>
            <div class="profile-chart__labels">
              <div class="profile-chart__label">
                                <span>
                                    Low
                                </span>
              </div>
              <div class="profile-chart__label">
                                <span>
                                    Medium
                                </span>
              </div>
              <div class="profile-chart__label">
                                <span>
                                    High
                                </span>
              </div>
            </div>
            <div class="profile-chart__graph">
              <span class="profile-chart__bar profile-chart__bar--gradient profile-chart__bar--empty"></span>
            </div>
            <div class="form__required profile__select">
              <select class="chart-select" v-on:change="onChartChange($event)">
                <option disabled hidden>
                  Evaluate
                </option>
                <option value="Low" data-percentage="0%">
                  Low
                </option>
                <option selected value="Medium" data-percentage="50%">
                  Medium
                </option>
                <option value="High" data-percentage="100%">
                  High
                </option>
              </select>
            </div>
          </div>
          <div class="profile-chart">
            <h2 class="title-small">
              Performance/Delivery:
            </h2>
            <div class="profile-chart__labels">
              <div class="profile-chart__label">
                                <span>
                                    Basic
                                </span>
              </div>
              <div class="profile-chart__label">
                                <span>
                                    General
                                </span>
              </div>
              <div class="profile-chart__label">
                                <span>
                                    Advanced
                                </span>
              </div>
              <div class="profile-chart__label">
                                <span>
                                    Expert
                                </span>
              </div>
            </div>
            <div class="profile-chart__graph">
              <span class="profile-chart__bar profile-chart__bar--empty"></span>
            </div>
            <div class="form__required profile__select">
              <select class="chart-select" v-on:change="onChartChange($event)">
                <option disabled hidden>
                  Evaluate
                </option>
                <option value="Basic" data-percentage="0%">
                  Basic
                </option>
                <option value="General" data-percentage="33.33%">
                  General
                </option>
                <option selected value="Advanced" data-percentage="66.66%">
                  Advanced
                </option>
                <option value="Expert" data-percentage="100%">
                  Expert
                </option>
              </select>
            </div>
          </div>
          <hr>
          <h2 class="title-large">
            Clinical Trial
          </h2>
          <div class="profile-chart">
            <h2 class="title-small">
              FLAURA
            </h2>
            <div class="profile-chart__labels">
              <div class="profile-chart__label">
                                <span>
                                    Basic
                                </span>
              </div>
              <div class="profile-chart__label">
                                <span>
                                    General
                                </span>
              </div>
              <div class="profile-chart__label">
                                <span>
                                    Advanced
                                </span>
              </div>
              <div class="profile-chart__label">
                                <span>
                                    Expert
                                </span>
              </div>
            </div>
            <div class="profile-chart__graph">
              <span class="profile-chart__bar profile-chart__bar--empty"></span>
            </div>
            <div class="profile__select">
              <select class="chart-select" v-on:change="onChartChange($event)">
                <option selected disabled hidden>
                  Evaluate
                </option>
                <option value="Basic" data-percentage="0%">
                  Basic
                </option>
                <option value="General" data-percentage="33.33%">
                  General
                </option>
                <option value="Advanced" data-percentage="66.66%">
                  Advanced
                </option>
                <option selected value="Expert" data-percentage="100%">
                  Expert
                </option>
              </select>
            </div>
          </div>
          <div class="profile-chart">
            <h2 class="title-small">
              MYKONOS
            </h2>
            <div class="profile-chart__labels">
              <div class="profile-chart__label">
                                <span>
                                    Basic
                                </span>
              </div>
              <div class="profile-chart__label">
                                <span>
                                    General
                                </span>
              </div>
              <div class="profile-chart__label">
                                <span>
                                    Advanced
                                </span>
              </div>
              <div class="profile-chart__label">
                                <span>
                                    Expert
                                </span>
              </div>
            </div>
            <div class="profile-chart__graph">
              <span class="profile-chart__bar profile-chart__bar--empty"></span>
            </div>
            <div class="profile__select">
              <select class="chart-select" v-on:change="onChartChange($event)">
                <option disabled hidden>
                  Evaluate
                </option>
                <option value="Basic" data-percentage="0%">
                  Basic
                </option>
                <option value="General" data-percentage="33.33%">
                  General
                </option>
                <option value="Advanced" data-percentage="66.66%">
                  Advanced
                </option>
                <option selected value="Expert" data-percentage="100%">
                  Expert
                </option>
              </select>
            </div>
          </div>
        </div>
      </div>
    </div>



    <!-- KEE Ranking History -->
    <div class="card card--extra-padding">
      <div class="card__heading">
        <h2 class="card__title">
          KEE Ranking History
        </h2>
        <div class="card__heading-button">
          <div class="button-group">
            <a href="#" class="button button--small">
              Back
            </a>
            <a href="#" class="button button--small">
              Profile
            </a>
            <a href="#" class="button button--small">
              Engagements
            </a>
            <a href="#" class="button button--small">
              Publications
            </a>
            <a href="#" class="button button--small button--green">
              Schedule
            </a>
          </div>
        </div>
      </div>
      <div class="profile-grid-evaluation">
        <div class="profile-grid">
          <div class="profile-grid__first">
            <div class="profile__rankings">
              <div class="profile__rankings-current">
                <div class="profile__ranking-title">
                  Evaluation 3 - <span>00/00/00</span>
                </div>
                <div class="profile__rankings-rank">
                  <img src="../../images/icon-award-advanced.svg">
                </div>
                <div class="profile__rankings-grade">
                  <div class="profile__rankings-text profile__rankings-text--grey">
                    Rank: Advanced
                  </div>
                  <div class="profile__rankings-text">
                    Grade: B
                  </div>
                  <img src="../../images/icon-grade-b.svg" class="profile__rankings-grade-icon">
                </div>
              </div>
            </div>
          </div>
          <div class="profile-grid__second">
            <div class="profile-chart">
              <h2 class="title-small">
                Understanding of Data:
              </h2>
              <div class="profile-chart__labels">
                <div class="profile-chart__label">
                                    <span>
                                        Basic
                                    </span>
                </div>
                <div class="profile-chart__label">
                                    <span>
                                        General
                                    </span>
                </div>
                <div class="profile-chart__label">
                                    <span>
                                        Advanced
                                    </span>
                </div>
                <div class="profile-chart__label">
                                    <span>
                                        Expert
                                    </span>
                </div>
              </div>
              <div class="profile-chart__graph">
                <span class="profile-chart__bar profile-chart__bar--empty" style="width: 66.66%;"></span>
              </div>
            </div>
            <div class="profile-chart">
              <h2 class="title-small">
                Commitment:
              </h2>
              <div class="profile-chart__labels">
                <div class="profile-chart__label">
                                    <span>
                                        Low
                                    </span>
                </div>
                <div class="profile-chart__label">
                                    <span>
                                        Medium
                                    </span>
                </div>
                <div class="profile-chart__label">
                                    <span>
                                        High
                                    </span>
                </div>
              </div>
              <div class="profile-chart__graph">
                <span class="profile-chart__bar profile-chart__bar--gradient profile-chart__bar--empty" style="width: 50%;"></span>
              </div>
            </div>
            <div class="profile-chart">
              <h2 class="title-small">
                Performance/Delivery:
              </h2>
              <div class="profile-chart__labels">
                <div class="profile-chart__label">
                                    <span>
                                        Basic
                                    </span>
                </div>
                <div class="profile-chart__label">
                                    <span>
                                        General
                                    </span>
                </div>
                <div class="profile-chart__label">
                                    <span>
                                        Advanced
                                    </span>
                </div>
                <div class="profile-chart__label">
                                    <span>
                                        Expert
                                    </span>
                </div>
              </div>
              <div class="profile-chart__graph">
                <span class="profile-chart__bar profile-chart__bar--empty" style="width: 33.33%;"></span>
              </div>
            </div>
          </div>
        </div>
      </div>
      <div class="profile-grid-evaluation">
        <div class="profile-grid">
          <div class="profile-grid__first">
            <div class="profile__rankings">
              <div class="profile__rankings-current">
                <div class="profile__ranking-title">
                  Evaluation 2 - <span>00/00/00</span>
                </div>
                <div class="profile__rankings-rank">
                  <img src="../../images/icon-award-general.svg">
                </div>
                <div class="profile__rankings-grade">
                  <div class="profile__rankings-text profile__rankings-text--grey">
                    Rank: General
                  </div>
                  <div class="profile__rankings-text">
                    Grade: C
                  </div>
                  <img src="../../images/icon-grade-c.svg" class="profile__rankings-grade-icon">
                </div>
              </div>
            </div>
          </div>
          <div class="profile-grid__second">
            <div class="profile-chart">
              <h2 class="title-small">
                Understanding of Data:
              </h2>
              <div class="profile-chart__labels">
                <div class="profile-chart__label">
                                    <span>
                                        Basic
                                    </span>
                </div>
                <div class="profile-chart__label">
                                    <span>
                                        General
                                    </span>
                </div>
                <div class="profile-chart__label">
                                    <span>
                                        Advanced
                                    </span>
                </div>
                <div class="profile-chart__label">
                                    <span>
                                        Expert
                                    </span>
                </div>
              </div>
              <div class="profile-chart__graph">
                <span class="profile-chart__bar profile-chart__bar--empty" style="width: 66.66%;"></span>
              </div>
            </div>
            <div class="profile-chart">
              <h2 class="title-small">
                Commitment:
              </h2>
              <div class="profile-chart__labels">
                <div class="profile-chart__label">
                                    <span>
                                        Low
                                    </span>
                </div>
                <div class="profile-chart__label">
                                    <span>
                                        Medium
                                    </span>
                </div>
                <div class="profile-chart__label">
                                    <span>
                                        High
                                    </span>
                </div>
              </div>
              <div class="profile-chart__graph">
                <span class="profile-chart__bar profile-chart__bar--gradient profile-chart__bar--empty" style="width: 50%;"></span>
              </div>
            </div>
            <div class="profile-chart">
              <h2 class="title-small">
                Performance/Delivery:
              </h2>
              <div class="profile-chart__labels">
                <div class="profile-chart__label">
                                    <span>
                                        Basic
                                    </span>
                </div>
                <div class="profile-chart__label">
                                    <span>
                                        General
                                    </span>
                </div>
                <div class="profile-chart__label">
                                    <span>
                                        Advanced
                                    </span>
                </div>
                <div class="profile-chart__label">
                                    <span>
                                        Expert
                                    </span>
                </div>
              </div>
              <div class="profile-chart__graph">
                <span class="profile-chart__bar profile-chart__bar--empty" style="width: 33.33%;"></span>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>

    <!-- Engagement details -->
    <div class="card card--extra-padding">
      <div class="card__heading">
        <h2 class="card__title">
          Engagement Details
        </h2>
        <div class="card__heading-button">
          <div class="button-group">
            <a href="#" class="button">
              Back
            </a>
            <a href="#" class="button button--green">
              Edit
            </a>
          </div>
        </div>
      </div>
      <div class="engagement-details">
        <div class="engagement-details__first">
          <div class="engagement-details__small m-bot">
            In Person/Digital
          </div>
          <div class="c-purple title-medium m-bot">
            Engagement Name...
          </div>
          <div class="c-purple">
            Wednesday, 30 June, 2021
          </div>
          <div class="c-purple">
            Start: 10:30 am
          </div>
          <div class="c-purple m-bot--2">
            End: 11:30 am
          </div>
          <div>
            Engagement Type: Ad Board
          </div>
          <div class="m-bot--2">
            Congress Link: None
          </div>
          <div>
            Data Sets:
            <div class="engagement-details__small">
              Early
            </div>
          </div>
        </div>
        <div class="engagement-details__second">
          <table class="engagement-details__table">
            <tr>
              <td class="engagement-details__table-title">
                House or Office Number:
              </td>
              <td>
                10a, Level 2
              </td>
            </tr>
            <tr>
              <td class="engagement-details__table-title">
                Street Address 1:
              </td>
              <td>
                Vega House
              </td>
            </tr>
            <tr>
              <td class="engagement-details__table-title">
                Street Address 2:
              </td>
              <td>
                Trinity Industrial Estate
              </td>
            </tr>
            <tr>
              <td class="engagement-details__table-title">
                County/State:
              </td>
              <td>
                Buckinghamshire
              </td>
            </tr>
            <tr>
              <td class="engagement-details__table-title">
                City:
              </td>
              <td>
                Milton Keynes
              </td>
            </tr>
            <tr>
              <td class="engagement-details__table-title">
                Postcode:
              </td>
              <td>
                MK11 0GH
              </td>
            </tr>
            <tr>
              <td class="engagement-details__table-title">
                Select Country:
              </td>
              <td>
                United Kindom
              </td>
            </tr>
          </table>
          <a href="#" class="engagement-details__meeting-link">
            <img class="meeting-icon" src="../../images/icon-meeting.svg">Digital Meeting
          </a>
        </div>
      </div>
      <hr>
      <table class="table">
        <thead>
        <th>
          Name
        </th>
        <th>
          Specialism
        </th>
        <th>
          Ranking
        </th>
        <th>
          Data
        </th>
        <th>
          Commitment
        </th>
        <th>
          Performance
        </th>
        <th>
          Action
        </th>
        </thead>
        <tr>
          <td>
            <div class="table__cell-with-icon">
                            <span class="table__icon">
                                <Icon icon="person" />
                            </span>
              Sarah Smith
            </div>
          </td>
          <td>
            Surgery
          </td>
          <td>
            B
          </td>
          <td>
            Expert
          </td>
          <td>
            Medium
          </td>
          <td>
            Advanced
          </td>
          <td class="table__buttons">
            <div class="buttons-group">
              <a href="#" class="button button--small">
                View
              </a>
            </div>
          </td>
        </tr>
        <tr class="table__spacer">
          <td colspan="5"></td>
        </tr>
        <tr>
          <td>
            <div class="table__cell-with-icon">
                            <span class="table__icon">
                                <Icon icon="person" />
                            </span>
              Sarah Smith
            </div>
          </td>
          <td>
            Surgery
          </td>
          <td>
            B
          </td>
          <td>
            Expert
          </td>
          <td>
            Medium
          </td>
          <td>
            Advanced
          </td>
          <td class="table__buttons">
            <div class="buttons-group">
              <a href="#" class="button button--small">
                View
              </a>
            </div>
          </td>
        </tr>
        <tr class="table__spacer">
          <td colspan="5"></td>
        </tr>
        <tr>
          <td>
            <div class="table__cell-with-icon">
                            <span class="table__icon">
                                <Icon icon="person" />
                            </span>
              Sarah Smith
            </div>
          </td>
          <td>
            Surgery
          </td>
          <td>
            B
          </td>
          <td>
            Expert
          </td>
          <td>
            Medium
          </td>
          <td>
            Advanced
          </td>
          <td class="table__buttons">
            <div class="buttons-group">
              <a href="#" class="button button--small">
                View
              </a>
            </div>
          </td>
        </tr>
      </table>
    </div>


    <!-- Publications -->
    <div class="card card--extra-padding">
      <div class="card__heading card__heading--margin">
        <h2 class="card__title">
          KEE Publications
        </h2>
        <div class="card__heading-button">
          <div class="button-group">
            <a href="#" class="button button--small">
              Back
            </a>
            <a href="#" class="button button--small">
              Profile
            </a>
            <a href="#" class="button button--small">
              Engagements
            </a>
            <a href="#" class="button button--small">
              History
            </a>
            <a href="#" class="button button--small button--green">
              Schedule
            </a>
          </div>
        </div>
      </div>
      <div class="publication">
        <div class="publication__content">
          <h2 class="title-medium m-bot">
            Publication Name...
          </h2>
          <h3 class="title-small c-purple m-bot">
            Pending/Complete
          </h3>
          <p class="c-darkest-grey">
            Maior solupta temporerum rem iumquam, as et int eiur magnimus et aut quam aut quatur sam fugiae quid et voluptati quature pelibuscimi.
          </p>
        </div>
        <div>
          <a href="#" class="button">
            Link
          </a>
        </div>
      </div>
      <div class="publication">
        <div class="publication__content">
          <h2 class="title-medium m-bot">
            Publication Name...
          </h2>
          <h3 class="title-small c-purple m-bot">
            Pending/Complete
          </h3>
          <p class="c-darkest-grey">
            Maior solupta temporerum rem iumquam, as et int eiur magnimus et aut quam aut quatur sam fugiae quid et voluptati quature pelibuscimi.
          </p>
        </div>
        <div>
          <a href="#" class="button">
            Link
          </a>
        </div>
      </div>
      <div class="publication">
        <div class="publication__content">
          <h2 class="title-medium m-bot">
            Publication Name...
          </h2>
          <h3 class="title-small c-purple m-bot">
            Pending/Complete
          </h3>
          <p class="c-darkest-grey">
            Maior solupta temporerum rem iumquam, as et int eiur magnimus et aut quam aut quatur sam fugiae quid et voluptati quature pelibuscimi.
          </p>
        </div>
        <div>
          <a href="#" class="button">
            Link
          </a>
        </div>
      </div>
    </div>


    <!-- Pagination -->
    <div class="card">
      <ul class="pagination">
        <li class="pagination__item">
          <a href="#" class="pagination__link pagination__first" disabled>
            First
          </a>
        </li>
        <li class="pagination__item">
          <a href="#" class="pagination__link pagination__prev">
            Previous
          </a>
        </li>
        <li class="pagination__item pagination__item--current">
          <span>1</span>/6
        </li>
        <li class="pagination__item">
          <a href="#" class="pagination__link pagination__next">
            Next
          </a>
        </li>
        <li class="pagination__item">
          <a href="#" class="pagination__link pagination__last">
            Last
          </a>
        </li>
      </ul>
    </div>


    <!-- Manage -->
    <div>
      <ul class="manage-buttons">
        <li class="manage-buttons__item">
          <a href="#" class="manage-buttons__link">
            <div class="manage-buttons__inner">
              <div class="manage-buttons__icon">
                <Icon icon="star" />
              </div>
              Roles
            </div>
          </a>
        </li>
        <li class="manage-buttons__item">
          <a href="#" class="manage-buttons__link">
            <div class="manage-buttons__inner">
              <div class="manage-buttons__icon">
                <Icon icon="lock" />
              </div>
              Permissions
            </div>
          </a>
        </li>
        <li class="manage-buttons__item">
          <a href="#" class="manage-buttons__link">
            <div class="manage-buttons__inner">
              <div class="manage-buttons__icon">
                <Icon icon="person" />
              </div>
              Users
            </div>
          </a>
        </li>
        <li class="manage-buttons__item">
          <a href="#" class="manage-buttons__link">
            <div class="manage-buttons__inner">
              <div class="manage-buttons__icon">
                <Icon icon="person" />
              </div>
              KEEs
            </div>
          </a>
        </li>
        <li class="manage-buttons__item">
          <a href="#" class="manage-buttons__link">
            <div class="manage-buttons__inner">
              <div class="manage-buttons__icon">
                <Icon icon="location" />
              </div>
              Engagement
            </div>
          </a>
        </li>
        <li class="manage-buttons__item">
          <a href="#" class="manage-buttons__link">
            <div class="manage-buttons__inner">
              <div class="manage-buttons__icon">
                <Icon icon="sliders" />
              </div>
              Evaluate
            </div>
          </a>
        </li>
      </ul>
    </div>
  </app-layout>
</template>

<script>
import AppLayout from '@/Layouts/AppLayout.vue'
import Welcome from '@/Jetstream/Welcome.vue'
import Icon from '@/Components/Icons.vue';
import EngagementForm from '@/Pages/LeicaComponent/Engagement/EngagementForm.vue';

export default {
  components: {
    AppLayout,
    Welcome,
    Icon,
    EngagementForm
  },

  data () {
    return {
      modalActive: false
    }
  },

  methods: {
    setBackgroundSize() {
      const charts = document.querySelectorAll('.profile-chart__graph')

      if (charts) {
        charts.forEach(chart => {
          let width = chart.clientWidth

          chart.querySelector('span').style.backgroundSize = width + 'px'
        })
      }
    },
    changeChart(element) {
      const parentEl = element.parentElement
      const siblingEl = parentEl.previousSibling
      const percentage = element.options[element.options.selectedIndex].dataset['percentage']

      siblingEl.querySelector('.profile-chart__bar').style.width = percentage
    },
    onChartChange(event) {
      this.changeChart(event.target)
    },
    showModal() {
      this.modalActive = true
    },
    hideModal() {
      this.modalActive = false
    }
  },

  mounted () {
    this.setBackgroundSize()

    window.addEventListener('resize', this.setBackgroundSize)

    const chartsSelect = document.querySelectorAll('.chart-select')

    chartsSelect.forEach(select => {
      this.changeChart(select)
    })

    const charts = document.querySelectorAll('.profile-chart__bar--empty')

    setTimeout(() => {
      charts.forEach(chart => {
        chart.classList.remove('profile-chart__bar--empty')
      })
    }, 300);
  }
}
</script>

